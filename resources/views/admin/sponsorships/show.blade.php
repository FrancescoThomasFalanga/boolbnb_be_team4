@extends('layouts.admin')

@section('content')

<div class="container sponsorship-container rounded my-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8">
           
            {{-- <h2 class="mb-lg-5 mb-4 text-center text-danger">Choose a sponsorship package</h2> --}}

            <form method="post" id="payment-form" action="{{ route('admin.sponsorships.store', $apartment->slug) }}">
                @csrf
                
                <div class="d-lg-none">

                    <div class="sponsorship-package package1">
                        <input type="radio" id="package1" name="amount" value="2.99" required>
                        <label for="package1" class="text-secondary">€2.99 per 24 ore di sponsorizzazione</label>
                    </div>
                    
                    <div class="sponsorship-package package2">
                        <input type="radio" id="package2" name="amount" value="5.99">
                        <label for="package2" class="text-secondary">€5.99 per 72 ore di sponsorizzazione</label>
                    </div>
                    
                    <div class="sponsorship-package package3">
                        <input type="radio" id="package3" name="amount" value="9.99">
                        <label for="package3" class="text-secondary">€9.99 per 144 ore di sponsorizzazione</label>
                    </div>

                </div>

                <div class="d-none d-lg-flex justify-content-around text-secondary">

                    <div class="card card-basic sponsorship-package mb-3">
                        <div class="card-body text-center">
                            <h3 class="card-title text-basic">Basico</h3>
                            <p class="card-text text-secondary">€2.99 per 24 ore</p>
                            <input type="radio" id="package1" name="amount" value="2.99" required>
                            <label for="package1"></label>
                        </div>
                    </div>

                    <div class="card card-gold sponsorship-package mb-3">
                        <div class="card-body text-center">
                            <h3 class="card-title text-gold">Oro</h3>
                            <p class="card-text text-secondary">€5.99 per 72 ore</p>
                            <input type="radio" id="package2" name="amount" value="5.99">
                            <label for="package2"></label>
                        </div>
                    </div>

                    <div class="card card-platinum sponsorship-package mb-3">
                        <div class="card-body text-center">
                            <h3 class="card-title text-plat">Platino</h3>
                            <p class="card-text text-secondary">€9.99 per 144 ore</p>
                            <input type="radio" id="package3" name="amount" value="9.99">
                            <label for="package3"></label>
                        </div>
                    </div>

                </div>

                <strong>
                    <div id="dropin-container" class="my-lg-5 my-3 border border-primary bg-light rounded px-3 pb-3 align-middle text-bold"></div>
                </strong>

                <input type="hidden" id="nonce" name="payment_method_nonce">

                <div class="text-center">
                    <a class="btn btn-outline-danger _btn-goback me-2" href="{{route ('admin.apartments.index')}}"><i class=" py-2 fa-solid fa-arrow-right-from-bracket"></i></a>
                    <button id="submit-button" class="sponsor-apt-now my-3 btn btn-primary">Sponsorizza Appartamento</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

<script src="https://js.braintreegateway.com/web/dropin/1.22.1/js/dropin.min.js"></script>

<script>
    var form = document.querySelector('#payment-form');
    var client_token = "{{ $token }}";

    braintree.dropin.create({
        authorization: client_token,
        container: '#dropin-container',
        }, function (createErr, instance) {
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            instance.requestPaymentMethod(function (err, payload) {
                if (err) {
                    console.log('Error', err);
                    return;
                }

                document.querySelector('#nonce').value = payload.nonce;
                form.submit();
            });
        });
    });
</script>

@endsection
