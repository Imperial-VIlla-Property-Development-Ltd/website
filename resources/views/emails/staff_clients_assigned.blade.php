@component('mail::message')
# 📌 New Client Assignment Summary

Hello **{{ $staff->name }}**,  
You have been assigned new client(s). Please review the list below.

---

## 👥 Assigned Clients

@component('mail::table')
| Name | Pension Number | Email |
|------|----------------|--------|
@foreach ($clients as $client)
| {{ $client->firstname }} {{ $client->lastname }} | 
  {{ $client->user->pension_number ?? 'N/A' }} |
  {{ $client->user->email ?? 'N/A' }} |
@endforeach
@endcomponent

---

@component('mail::button', ['url' => route('dashboard.staff')])
Go to Staff Dashboard
@endcomponent

Thanks,<br>
**{{ config('app.name') }}**
@endcomponent
