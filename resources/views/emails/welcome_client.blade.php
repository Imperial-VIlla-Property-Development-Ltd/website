@component('mail::message')
# Welcome to ImperialVilla 🌟

Dear {{ $client->full_name }},

Your ImperialVilla account has been successfully created.  
We’re thrilled to have you on board!

### Account Details:
- **Email:** {{ $client->email }}
- **Pension ID:** {{ $client->pension_id }}
- **Phone:** {{ $client->phone }}

You can now log in to your client dashboard to track your pension process and view updates.

@component('mail::button', ['url' => url('/client/login')])
Go to Dashboard
@endcomponent

Warm regards,  
**The ImperialVilla Team**  
_Doho Plaza, Bauchi Road, Gombe, Nigeria_  
[imperialvillapropertyltd@gmail.com](mailto:imperialvillapropertyltd@gmail.com)
@endcomponent
