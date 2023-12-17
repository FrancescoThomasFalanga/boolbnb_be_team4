<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Sponsorship;
use Illuminate\Http\Request;
use Braintree\Gateway;

class SponsorshipController extends Controller
{
    protected $gateway;

    public function __construct()
    {
        $this->gateway = new Gateway([
            'environment' => env('BRAINTREE_ENV'),
            'merchantId' => env('BRAINTREE_MERCHANT_ID'),
            'publicKey' => env('BRAINTREE_PUBLIC_KEY'),
            'privateKey' => env('BRAINTREE_PRIVATE_KEY')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $slug)
    {
                // Sponsorship types mapping
                $sponsorshipTypes = [
                    '2.99' => ['name' => 'short', 'duration' => 24],
                    '5.99' => ['name' => 'middle', 'duration' => 72],
                    '9.99' => ['name' => 'long', 'duration' => 144],
                ];
        
                // Find the apartment with the given slug
                $apartment = Apartment::where('slug', $slug)->firstOrFail();
        
                $amount = $request->amount;
                $nonce = $request->payment_method_nonce;
        
                $result = $this->gateway->transaction()->sale([
                    'amount' => $amount,
                    'paymentMethodNonce' => $nonce,
                    'options' => [
                        'submitForSettlement' => True
                    ]
                ]);
        
                if ($result->success) {
        
                    if (!array_key_exists($amount, $sponsorshipTypes)) {
                        return back()->withErrors('Invalid sponsorship type.');
                    }
        
                    $sponsorshipData = $sponsorshipTypes[$amount];
        
                    $sponsorship = Sponsorship::where('name', $sponsorshipData['name'])->first();
        
                    $apartment->sponsorships()->attach($sponsorship->id, ['start_date' => \Carbon\Carbon::now()]);
        
                    return redirect()->route('admin.apartments.show', $apartment->slug)->with('success_message', 'Transaction successful. The sponsorship is now active.');
                } else {
                    return back()->withErrors('An error occurred with the message: ' . $result->message);
                }
    }

    public function show($slug)
    {
        // Find the apartment with the given slug
        $apartment = Apartment::where('slug', $slug)->firstOrFail();

        // Get the sponsorships associated with the apartment
        $sponsorships = $apartment->sponsorships;

        // Let's take the latest sponsorship for this example, you might want to adapt this as per your needs
        $sponsorship = $sponsorships->last();

        // Generate the Braintree token
        $token = $this->gateway->clientToken()->generate();

        return view('admin.sponsorships.show', compact('sponsorship', 'apartment', 'token'));
    }

    public function update(Request $request, Sponsorship $sponsorship)
    {
        $amount = $request->amount;
        $nonce = $request->payment_method_nonce;

        $result = $this->gateway->transaction()->sale([
            'amount' => $amount,
            'paymentMethodNonce' => $nonce,
            'options' => [
                'submitForSettlement' => True
            ]
        ]);

        if ($result->success) {
            // Handle post-payment success logic here (e.g. update the sponsorship's status)
            return back()->with('success_message', 'Transaction successful. The sponsorship is now active.');
        } else {
            // Handle post-payment failure logic here
            return back()->withErrors('An error occurred with the message: ' . $result->message);
        }
    }
}
