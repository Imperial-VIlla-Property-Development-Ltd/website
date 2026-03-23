@props(['step' => 1])

@php
  // Define the entire registration flow steps
  $steps = [
      1 => 'Biodata',
      2 => 'PFA Selection',
      3 => 'Payment',
      4 => 'Undertaking',
      5 => 'Upload Documents',
      6 => 'Registration Proof',
  ];

  // Fallback if step is missing or out of range
  $total = count($steps);
  $current = isset($steps[$step]) ? $steps[$step] : 'Onboarding';
  $percent = ($step / $total) * 100;
@endphp



  



  

  