@component('mail::message')
# {{ $newStatus === 'shutdown' ? '🚨 Portal Offline for Maintenance' : '✅ Portal is Active Again' }}

Hello,

The portal status has recently changed:

@component('mail::panel')
**Current Status:**  
@if($newStatus === 'shutdown')
🔴 **OFFLINE — The system is temporarily unavailable due to maintenance.**
@else
🟢 **ACTIVE — The system is back online and fully functional.**
@endif
@endcomponent

@if($newStatus === 'shutdown')
We are performing necessary upgrades and improvements to enhance system stability and performance.

Please wait for further updates.
@else
You may now continue using the system as normal.  
Thank you for your patience!
@endif

Thanks,  
**{{ config('app.name') }} Team**
@endcomponent
