<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Registration Proof - {{ $client->registration_id }}</title>

  <style>
    @page { margin: 35px 35px; }

    body {
      font-family: 'DejaVu Sans', sans-serif;
      color: #0b0b0b;
      line-height: 1.35;
      text-align: center;
      background: #f6f9ff; /* Soft light background */
    }

    .certificate {
      border: 2px solid #090ce4ff; /* DO NOT CHANGE */
      padding: 22px 26px;
      border-radius: 14px;
      position: relative;
      background: linear-gradient(145deg, #ffffff, #f2f4ff); /* Subtle gradient */
      box-shadow: 0 0 6px rgba(0,0,0,0.08);
    }

    .header {
      margin-bottom: 10px;
    }

    .header img {
      width: 70px;
      height: 70px;
      margin-bottom: 5px;
    }

    .header h1 {
      font-size: 24px;
      margin: 6px 0;
      color: #0a2fa4;
      font-weight: 800;
      letter-spacing: 0.6px;
      text-transform: uppercase;
    }

    .sub-title {
      color: #444;
      font-size: 12px;
      margin-top: -3px;
      font-style: italic;
    }

    .divider {
      border-top: 1px solid #c7c7c7;
      margin: 12px 0;
    }

    .client {
      display: flex;
      align-items: center;
      margin-top: 8px;
      justify-content: center;
    }

    .client img {
      width: 82px;
      height: 82px;
      border-radius: 50%;
      border: 3px solid #004aad;
      margin-right: 12px;
      object-fit: cover;
      box-shadow: 0 0 6px rgba(0,0,0,0.15);
    }

    .info {
      margin-top: 12px;
    }

    .info p {
      font-size: 13px;
      margin: 3px 0;
    }

    .info strong {
      color: #003a94;
    }

    .status {
      margin-top: 20px;
      background: #eaf2ff;
      padding: 9px 12px;
      border-left: 4px solid #004aad;
      border-radius: 6px;
      font-size: 12px;
      color: #333;
    }

    .qr {
      margin-top: 18px;
    }

    .qr img {
      border: 1px solid #ddd;
      padding: 4px;
      width: 115px;
      height: 115px;
      border-radius: 6px;
      background: #fff;
    }

    .signature {
      text-align: right;
      margin-top: 25px;
      padding-right: 5px;
    }

    .signature-line {
      width: 160px;
      height: 1px;
      background: #000;
      margin-left: auto;
    }

    .signature p {
      font-size: 11px;
      margin-top: 3px;
      font-weight: 600;
    }

    .footer {
      font-size: 10px;
      color: #666;
      margin-top: 22px;
      padding-top: 6px;
      border-top: 1px solid #ccc;
    }

    .watermark {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      opacity: 0.05;
      font-size: 80px;
      color: #004aad;
      font-weight: 900;
      letter-spacing: 2px;
      text-transform: uppercase;
      pointer-events: none;
      white-space: nowrap;
    }
  </style>
</head>

<body>

<div class="certificate">

  <div class="watermark">IMPERIALVILLA</div>

  {{-- HEADER --}}
  <div class="header">
      <img src="{{ public_path('images/logo.png') }}" alt="Logo">
      <h1>ImperialVilla 25% Equity Processing Portal</h1>
      <p class="sub-title">Official Proof of Registration</p>
  </div>

  <div class="divider"></div>

  {{-- CLIENT DETAILS --}}
  <div class="client">
      <img 
          src="{{ $user->profile_photo 
                    ? public_path('storage/' . $user->profile_photo) 
                    : public_path('default-avatar.png') 
               }}" 
          alt="Passport"
      >

      <div style="text-align:center;">
          <p><strong>{{ strtoupper($client->firstname.' '.$client->lastname) }}</strong></p>
          <p>Email: {{ $user->email }}</p>
          <p><strong>Registration ID:</strong> {{ $client->registration_id }}</p>
      </div>
  </div>

  {{-- FULL INFORMATION --}}
  <div class="info">
      <p><strong>Pension Number:</strong> {{ $user->pension_number ?? 'N/A' }}</p>
      <p><strong>PFA:</strong> {{ $client->pfa_selected ?? 'Not Selected' }}</p>
      <p><strong>Phone Number:</strong> {{ $client->phone_number }}</p>
      <p><strong>Registration Date:</strong> {{ $client->created_at->format('d M, Y') }}</p>

      <p><strong>Registration Fee:</strong>
        @if($isPaid)
          ₦{{ number_format($client->fee_amount ?? 100000, 2) }} (Paid)
        @else
          Not Paid
        @endif
      </p>
  </div>

  {{-- STATUS --}}
  <div class="status">
      Your registration has been successfully received and verified in the ImperialVilla  System.
  </div>

  {{-- QR CODE --}}
  <div class="qr">
      <img src="{{ $qrCodeSrc }}" alt="QR Code">
  </div>

  {{-- SIGNATURE --}}
<div class="signature" style="position: relative;">

    {{-- Digital Stamp --}}
    <img src="{{ public_path('images/stamp.jpg') }}"
         alt="Digital Signature"
         style="
            width: 120px;
            opacity: 0.49;
            position: absolute;
            right: 0;
            top: -120px;
            transform: rotate(-8deg);
         ">
        
   
        

<p>Authorized Signature</p>
</div>


  {{-- FOOTER --}}
  <div class="footer">
      ImperialVilla  Portal © {{ now()->format('Y') }} — All Rights Reserved.
  </div>

</div>

</body>
</html>
