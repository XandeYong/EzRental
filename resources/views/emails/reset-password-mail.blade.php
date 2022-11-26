@component('mail::message')
# EzRental Auto Mailing System
<br>
Hello, We are from EZRental. <br>
We would like to inform you that your account has requested an <b>Reset Password Request</b> from us. <br>
<br>
<b>Name:</b> {{ $data['name'] }} <br>
<b>Email:</b> {{ $data['email'] }} <br>
<b>Date:</b> {{ $data['date'] }} <br>
<b>Time:</b> {{ $data['time'] }} <br>

@component('mail::button', ['url' => $data['url'], 'color' => 'danger'])
Reset Password
@endcomponent

@component('mail::panel')
Once the button is clicked, the button will not be able to use again. <br>
<br>
If the button doesn't work, please request from us again.
@endcomponent



<b>Please do not reply to this email, this is an official mailing bot.</b>
@endcomponent