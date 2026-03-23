@extends('emails.layout')

@section('content')

<h2 style="text-align:center; color:#004aad; font-size:22px; margin-bottom:20px;">
    Your ImperialVilla OTP Code
</h2>

<p style="font-size:15px; line-height:1.6;">
    Hello,<br><br>
    Please use the OTP code below to complete your login:
</p>

<!-- OTP Display -->
<div style="text-align:center; margin:25px 0;">
    <div style="font-size:38px; font-weight:bold; color:#004aad; letter-spacing:10px;">
        {{ $otp }}
    </div>

    <p style="font-size:13px; color:#777; margin-top:8px;">
        Expires at: <strong>{{ $expiresAt->format('h:i A') }}</strong>
    </p>
</div>

<p style="font-size:14px; line-height:1.6;">
    If you did not request this code, please ignore this email.
</p>

@endsection
