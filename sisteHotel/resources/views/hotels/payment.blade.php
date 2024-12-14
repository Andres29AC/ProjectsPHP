@extends('layouts.app')

@section('content')
    <div class="hero-wrap js-fullheight" style="margin-top: -25px;background-image: url('{{asset('images/room-1.jpg')}}');">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-start" data-scrollax-parent="true">
            <div class="col-md-7 ftco-animate">
                <h2 class="subheading">Pay With PayPal</h2>
                <h1 class="mb-4"></h1>
            </div>
            </div>
        </div>
        </div>
    </div>
    <div class="container" style="display: flex; justify-content: center; align-items: center;">
        <div id="paypal-button-container" class="paypal-button-container"></div>
        <p id="result-message"></p>

        <script src="https://www.paypal.com/sdk/js?client-id={{ $paypalClientId }}&buyer-country=US&currency=USD&components=buttons&enable-funding=venmo">
            
        </script>
        <script>
            const successUrl = "{{ url('hotels/success') }}";
            const sessionPrice = "{{ Session::get('price') }}";
        </script>
        <script src="/js/payment.js"></script>
    </div>
@endsection