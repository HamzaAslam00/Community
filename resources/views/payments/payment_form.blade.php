@extends('layouts.guest')

@section('styles')
    <style>
        .selected-card {
            color: #3c4d62;
            background-color: #fff;
            border: 1px solid #854fff;
            outline: 0;
            box-shadow: 0 0 0 3px rgb(133 79 255 / 10%) !important;
        }
        .gy-3 > div {
            padding-top: 0px !important;
            padding-bottom: 0px !important;
        }

        .StripeElement {
            background-color: white;
            padding: 8px 12px;
            border-radius: 4px;
            border: 1px solid transparent;
            box-shadow: 0 1px 3px 0 #e6ebf1;
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;
        }
    
        .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        }
    
        .StripeElement--invalid {
            border-color: #fa755a;
        }
    
        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
        }
    </style>
@endsection

@section('content')
<div class="nk-block nk-block-middle nk-auth-body  wide-xs">
    <div class="brand-logo pb-4 text-center">
        <a href="/" class="logo-link">
            <img class="logo-light logo-img logo-img-lg" src="{{ asset('images/logo.png') }}" alt="logo">
            <img class="logo-dark logo-img logo-img-lg" src="{{ asset('images/logo-dark.png') }}" alt="logo-dark">
        </a>
    </div>
    <div class="card">
        <div class="card-inner card-inner-lg">
            <div class="nk-block-head">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title">{{ $registrationPage->title }}</h4>
                    {{-- <div class="nk-block-des">
                        <p>Hi Pay the following tickets to activate your account.</p>
                    </div> --}}
                </div>
            </div>
            <form method="post" action="{{ route('register') }}" class="gy-3 form-validate is-alter">
                @csrf
                <input type="hidden" value="{{ $registrationPage->id }}" name="registration_page_id">
                <input type="hidden" name="ticket_id" id="ticket_id">
                <div class="form-group">
                    <div class="form-label-group">
                        <label class="form-label" for="first_name">First Name</label>
                    </div>
                    <div class="form-control-wrap">
                        <input type="text" class="form-control form-control-lg" id="first_name" name="first_name" placeholder="Enter your first name" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-label-group">
                        <label class="form-label" for="last_name">Last Name</label>
                    </div>
                    <div class="form-control-wrap">
                        <input type="text" class="form-control form-control-lg" id="last_name" name="last_name" placeholder="Enter your last name" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-label-group">
                        <label class="form-label" for="email">Email</label>
                    </div>
                    <div class="form-control-wrap">
                        <input type="text" class="form-control form-control-lg" id="email" name="email" placeholder="Enter your email address" required>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-label-group">
                        <label class="form-label">Select a Ticket to proceed</label>
                    </div>
                </div>
                <div class="row">
                    @foreach ($registrationPage->tickets as $ticket)
                        <div class="col-md-6">
                            <div class="card ticket-card" data-ticket-id="{{ $ticket->id }}" style="cursor: pointer;">
                                <div class="card-inner">
                                    <div class="font-weight-bold text-center">{{ $ticket->title }}</div>
                                    <div class="">{{ addEllipsis($ticket->description, 15) }}</div>
                                    <div class="font-weight-bold">Price: ${{ $ticket->amount }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-center mt-2">
                    <div class="spinner-border d-none" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </form>
            <div class="payment-form d-none">
                <form action="{{route('process-payment')}}" method="POST" id="subscribe-form" class="mt-3">
                    @csrf
                    <div class="form-group">
                        <div class="form-label-group">
                            <label class="form-label" for="card-holder-name">Card Holder Name</label>
                        </div>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-lg StripeElement" id="card-holder-name" name="card-holder-name" placeholder="Enter your name" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <label for="card-element">Credit or debit card</label>
                        <div id="card-element" class="form-control"></div>
                        <!-- Used to display form errors. -->
                        <div id="card-errors" role="alert"></div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-lg btn-primary btn-block pay" id="card-button" data-secret="" style="margin-top: 28px" >Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('layouts.partials.footer')
@endsection

@push('scripts')
    <script>
        $(function(){
            sessionStorage.clear();
        })
        $('.ticket-card').on('click', function() {
            let formIsValid = $('.form-validate').valid({
                rules: {
                    first_name: {
                        required: true,
                        regex: true
                    },
                    last_name: {
                        required: true,
                        regex: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                }
            });
            if(formIsValid) {
                $(this).addClass('selected-card').parent().siblings().children().removeClass('selected-card');
                $('#ticket_id').val($(this).data('ticket-id'));
                $('.payment-form').addClass('d-none');
                var form = $('.form-validate');
                $('.spinner-border').removeClass('d-none');
                window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
                window.axios({
                    url: form.attr('action'),
                    method: form.attr('method'),
                    data: new FormData(form[0]),
                })
                .then(response => {
                    if (response.status == 200) {
                        $('#card-button').attr('data-secret', response.client_secret);
                        $('.spinner-border').addClass('d-none');
                        $('.payment-form').removeClass('d-none');
                    }
                    else {
                        window.toast.fire({
                            title: response.data.message,
                            icon: 'error',
                        });
                    };
                })
                .catch(error => {
                    window.toast.fire({
                        title: error.response.data.message,
                        icon: 'error',
                    });
                })
                .finally(response => {
                    $('.spinner-border').addClass('d-none');
                })
            }
        });
    </script>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        var stripe = Stripe('{{ config('services.stripe.key') }}');
            var elements = stripe.elements();
            var style = {
                base: {
                    color: '#32325d',
                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                    fontSmoothing: 'antialiased',
                    fontSize: '16px',
                    '::placeholder': {
                        color: '#aab7c4'
                    }
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a'
                }
            };
            var card = elements.create('card', {hidePostalCode: true,
                style: style});
            card.mount('#card-element');
            card.addEventListener('change', function(event) {
                var displayError = document.getElementById('card-errors');
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }
            });
            const cardHolderName = document.getElementById('card-holder-name');
            const cardButton = document.getElementById('card-button');
            const clientSecret = cardButton.dataset.secret;
            cardButton.addEventListener('click', async (e) => {
                e.preventDefault();
                console.log("attempting");
                cardButton.setAttribute('disabled', true);
                const { setupIntent, error } = await stripe.confirmCardSetup(
                    clientSecret, {
                        payment_method: {
                            card: card,
                            billing_details: { name: cardHolderName.value }
                        }
                    });
                if (error) {
                    var errorElement = document.getElementById('card-errors');
                    errorElement.textContent = error.message;
                    cardButton.removeAttribute('disabled');
                } else {
                    paymentMethodHandler(setupIntent.payment_method);
                }
            });
            function paymentMethodHandler(payment_method) {
                const cardButton = document.getElementById('card-button');
                var form = document.getElementById('subscribe-form');
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'payment_method');
                hiddenInput.setAttribute('value', payment_method);
                form.appendChild(hiddenInput);
                axios({
                    url: form.getAttribute('action'),
                    method: form.getAttribute('method'),
                    data: new FormData(form),
                })
                .then(response => {
                    if (response.status == 200) {
                        window.toast.fire({
                            title: response.data.message,
                            icon: 'success',
                        });
                        cardButton.removeAttribute('disabled');
                        // window.location.href = '{{  route("login")  }}';
                    }
                    else {
                        window.toast.fire({
                            title: response.data.message,
                            icon: 'error',
                        });
                        cardButton.removeAttribute('disabled');
                    };
                })
                .catch(error => {
                    window.toast.fire({
                        title: error.response.data.message,
                        icon: 'error',
                    });
                    cardButton.removeAttribute('disabled');
                })
            }
    </script>
@endpush