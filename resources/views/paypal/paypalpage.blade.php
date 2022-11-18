<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @include('base.head')
    <link rel="stylesheet" href="{{ asset("/css/dashboard/dashboard_index.css")}}">
    <link rel="stylesheet" href="{{ asset("/css/paypal/paypal.css")}}">

    <!-- Include the PayPal JavaScript SDK; -->
    <script src="https://www.paypal.com/sdk/js?client-id=ASGYj9RiBQZu2Onbe54GUBNVPkFUFv5ffVeWPm4s7YZEdW9b5qTyHXbFYvBfoO2IOgrS0J8BCYYNHaM1&currency=MYR&disable-funding=credit,card"></script>
</head>
<body>

    <form id="form1" runat="server">
        <div>
            <div id="smart-button-container">
                <div class="container push-top">
                    <div class="content">
                        <div class="row justify-content-center">
                            <div class="col-sm-8 content-1">
                                <div class="d-flex justify-content-center">
                                    <div class="back">
                                        <a href="{{ URL('/dashboard/rentingrecord/getrecordDetails/'. Crypt::encrypt($renting_id)) }}" class="hlBack btn btn-outline-dark fs-20px align-items-center d-inline-flex">
                                            <i class="ico ico-sm ico-chevron-left"></i>
                                            Back
                                        </a>
                                    </div>
                                    <div class="title">
                                        <h1>PayPal Payment</h1>
                                    </div>
                                    <div class="temp"></div>
                                </div>
                                <hr />
                                <div class="d-flex justify-content-center">
                                    <p class="text-center">
                                        We provide you safety in making transaction,<br />
                                        We will never charge a penny on your transaction,<br />
                                        So why the hesitate? <br /> <br />
                                        Click the button below and make Payment with paypal now!
                                    </p>
                                </div>
                                <hr />
                                <!-- Set up a container element for the button -->
                                <div id="paypal-button-container" class="text-center"></div>
                            </div>

                        </div>
                        
                    </div>
                </div>
            </div>
        </div>

    </form>

{{-- Paypal start here --}}
<script>
  paypal.Buttons({
    // Sets up the transaction when a payment button is clicked
    style: {
                shape: 'pill',
                color: 'gold',
                layout: 'vertical',
                label: 'paypal',

            },

// This function sets up the details of the transaction, including the amount and line item details.
    createOrder: (data, actions) => {
      return actions.order.create({
        purchase_units: [{
          amount: {
            value: {{ $payAmount }} // Can also reference a variable or function
          }
        }],
        application_context: {
             shipping_preference: "NO_SHIPPING"
         }
      });
    },

    // Finalize the transaction after payer approval
    onApprove: (data, actions) => {
      return actions.order.capture().then(function(orderData) {

            const element = document.getElementById('paypal-button-container');
            element.innerHTML = '<h3>Thank you for your payment. Receipt had sent to your email.</h3>';
            window.alert('Thank you for your payment. Receipt had sent to your email.');

            document.location.href ='/dashboard/payment/paymentSuccess';

      });
    }


  }).render('#paypal-button-container');

</script>


</body>
</html>
