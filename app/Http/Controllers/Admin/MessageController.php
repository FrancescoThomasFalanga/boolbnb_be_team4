<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{

    public function showByApartment($apartmentId)
    {
        $apartment = Apartment::where('id', $apartmentId)->where('user_id', Auth::id())->first();

        if (!$apartment) {
            abort(404);  // Not Found
        }

        $messages = Message::where('apartment_id', $apartmentId)->orderBy('created_at', 'desc')->get();

        return view('admin.messages.index', compact('messages'));
    }
}
