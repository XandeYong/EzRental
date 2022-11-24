@component('mail::message')
# EzRental Auto Mailing System

Hello, We are from EZRental. 
We would like to inform you that your account have request an <b>Reset Password Request</b> from us. <br>

<b>Name:</b> {{ $data['name'] }}
<b>Email:</b> {{ $data['email'] }}
<b>Date:</b> {{ $data['date'] }} 
<b>Time:</b> {{ $data['time'] }} 

<br>
@component('mail::button', ['url' => $data['url']])
Reset Password
@endcomponent

Thanks,<br>
{{ config('app.name') }}
<br>
Please do not reply to this email, this is an official auto mailing bot.
@endcomponent