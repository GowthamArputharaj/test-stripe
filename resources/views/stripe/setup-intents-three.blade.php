<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Setup Intents
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <form action="{{ route('subscription.subscribe') }}" method="POST" id="stripe-form" >
                    @csrf
                    {{-- Stripe Code --}}
                    <input id="card-holder-name" type="text" class="my-4">

                    <div class="my-2 p-4 bg-blue-100">
                        <label for="standard">Standard</label>
                        <input type="radio" name="plan" id="standard" value="price_1IP7UmGAqYFngkaCEPvNF3Go" >
    
                        <label for="premium">Premium</label>
                        <input type="radio" name="plan" id="premium" value="price_1IP7UmGAqYFngkaC8Fi7KBg0" >
                    </div>

                    <!-- Stripe Elements Placeholder -->
                    <div id="card-element"></div>
                    
                    <button id="card-button" data-secret="{{ $intent->client_secret }}">
                        Update Payment Method
                    </button>
                </form>

                <input type="hidden" id="key" value="{{ env('STRIPE_KEY') }}">

            </div>
        </div>
    </div>
    @push('scripts')
    
    <script src="https://js.stripe.com/v3/"></script>

    <script>
        // Sweet alert
        // import Swal from 'sweetalert2'
        // const Swal = require('sweetalert2');

        // two
        const stripe = Stripe(document.querySelector('#key').value);

        const elements = stripe.elements();
        const cardElement = elements.create('card');

        cardElement.mount('#card-element');

        // three
        const cardHolderName = document.getElementById('card-holder-name');
        const cardButton = document.getElementById('card-button');
        const clientSecret = cardButton.dataset.secret;

        cardButton.addEventListener('click', async (e) => {
            e.preventDefault();
            // alert('iiiiiiiiiiiiiii')
            const { setupIntent, error } = await stripe.confirmCardSetup(
                clientSecret, {
                    payment_method: {
                        card: cardElement,
                        billing_details: { name: cardHolderName.value }
                    }
                }
            );

            console.log('Gowtham')
            // alert('asdf')

            if (error) {
                // Display "error.message" to the user...
                // Swal.fire({
                //     title: 'Error', 
                //     text: 'Something is wrong',
                //     icon: 'error', 
                //     confirmButtonText: 'Okay..'
                // });

                console.log(error);
            } else {
                // The card has been verified successfully...
                // Swal.fire({
                //     title: 'Success ', 
                //     text: 'Something is Good',
                //     icon: 'success', 
                //     confirmButtonText: 'Okay..'
                // });
                console.log(setupIntent);


                var newHidden = document.createElement('input');
                newHidden.setAttribute('value', setupIntent.payment_method);
                newHidden.setAttribute('name', 'payment_method');
                newHidden.setAttribute('type', 'hidden');

                document.querySelector('#stripe-form').appendChild(newHidden);

                // $('#stripe-form').submit();

                await stripe.createToken(cardElement)
                .then((result) => {
                    var newHidden = document.createElement('input');
                    newHidden.setAttribute('value', result.token.id);
                    newHidden.setAttribute('name', 'stripe_token');
                    newHidden.setAttribute('type', 'hidden');

                    document.querySelector('#stripe-form').appendChild(newHidden);


                    console.log(result.token.id);
                    console.log(result);
                })


                $('#stripe-form').submit();

            }



        });

        console.log('I am working');
        
    </script>
    @endpush
</x-app-layout>