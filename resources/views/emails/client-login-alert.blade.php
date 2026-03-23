@extends('emails.layout')

@component('mail::message')

# 🔐 New Login Detected

Hello **{{ $user->name }}**,  
A login was just detected on your **ImperialVilla Portal** account.

---

### 📌 Login Details

- **IP Address:** {{ $ip }}
- **Login Time:** {{ $time }}
- **Browser:** {{ request()->header('User-Agent') }}

---

If this was *not you*, please reset your password immediately and contact support.

@component('mail::button', ['url' => route('profile.edit')])
Review Account
@endcomponent

Thanks,  
**ImperialVilla Security Team**

@endcomponent
