<!DOCTYPE html>

<html>
<head>
</head>

<body>
    <p>Hi <b>{{ $mailData['name'] }}</b>,</p>

    <p>We are from EZRental. We would like to inform you that your account have been <b>Banned</b > for <b>
    @if ($mailData['duration']== 0)
        permanent
    @else
    {{ $mailData['duration'] }} days
    @endif</b> started on <b>{{ $mailData['dateTime'] }}</b>.</p>
     
    <p><b>Reason:</b > {{ $mailData['reason'] }}</b>.</p>

    <p>Thank you.</p>

</body>

</html>