<!DOCTYPE html>

<html>
<head>
</head>

<body>
    <p>Hi <b>{{ $mailData['name'] }}</b>,</p>

    <p>We are from EZRental. We have received your <b>Payment</b > on <b>{{ $mailData['dateTime'] }}</b>. Receipt are shown below.</p>

    <p>Thank you.</p>

    <br /><hr style='width: 100%;'>

    <p><u><h2>Receipt:</h2></u></p>
     
                        {{-- For loop records --}}
                        @for ($i = 0; $i < count($mailData['paymentDetails']); $i++)
                            

                        <h3><u>{{ $mailData['paymentDetailsName'][$i] }}</u></h3>    

                        <label>Payment ID: {{ $mailData['paymentDetails'][$i]->payment_id }}</label><br />
                        <label>Payment date: {{ $mailData['paymentDetails'][$i]->paid_date }}</label><br />
                        <label>Renting ID: {{ $mailData['paymentDetails'][$i]->renting_id }}</label><br />
                        <label>Status: {{ $mailData['paymentDetails'][$i]->status }}</label><br />
                        <label>Payment Method: {{ $mailData['paymentDetails'][$i]->payment_method }}</label><br />
                        <label>Payment Type: {{ $mailData['paymentDetails'][$i]->payment_type }}</label><br />
                        <label>Amount: {{ $mailData['paymentDetails'][$i]->amount }}</label><br />
                        
                        
                        @endfor
                        <br /><hr style='width: 100%;'>


</body>

</html>