@extends('emails.layout')

<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Welcome to ImperialVilla</title>

  <style>
    body { margin:0; padding:0; background:#eef1f7; font-family:Arial, sans-serif; }

    img { border:0; outline:none; display:block; }

    .button {
      display:inline-block;
      padding:12px 22px;
      border-radius:6px;
      font-weight:600;
      text-decoration:none;
    }

    @keyframes shimmer {
      0% { background-position: -200px 0; }
      100% { background-position: 200px 0; }
    }

    .gradient-header {
      background: linear-gradient(135deg, #004aad 0%, #0b63d6 40%, #3b82f6 100%);
      animation: shimmer 2.5s infinite linear;
      background-size: 200% 100%;
    }

    @media only screen and (max-width:600px) {
      .container { width:100% !important; }
      .two-col { display:block !important; }
      .two-col .column { width:100% !important; display:block; }
    }
  </style>
</head>

<body>

  <table width="100%" cellpadding="0" cellspacing="0" style="padding:36px 0; background:#e9eef6;">
    <tr>
      <td align="center">

        <table width="620" cellpadding="0" cellspacing="0" class="container"
               style="background:#ffffff; border-radius:14px; overflow:hidden; 
                      box-shadow:0 10px 30px rgba(0,0,0,0.12);">

          <!-- BEAUTIFUL GRADIENT HEADER -->
          <tr>
            <td class="gradient-header" style="padding:30px; text-align:center;">
              <h1 style="margin:0; font-size:26px; color:white; font-weight:700;">
                Welcome to ImperialVilla!
              </h1>
              <p style="margin:8px 0 0 0; color:#eaf2ff; font-size:14px;">
                Portal
              </p>
            </td>
          </tr>

          <!-- BODY -->
          <tr>
            <td style="padding:28px 34px; color:#2b3440;">

              <h2 style="text-align:center; color:#004aad; font-size:22px; margin:0 0 12px 0;">
                Hello {{ $client->firstname ?? $user->name }}, your registration is complete 🎉
              </h2>

              <p style="text-align:center; color:#5b6b7a; font-size:15px; line-height:1.6;">
                Thank you for registering with ImperialVilla.  
                Here is your full registration summary:
              </p>

              <!-- TWO COLUMN LAYOUT -->
              <table width="100%" class="two-col" cellpadding="0" cellspacing="0">
                <tr>

                  <!-- LEFT (DETAILS) -->
                  <td class="column" style="width:55%; padding-right:20px;">
                    <table width="100%" cellpadding="0">
                      <tr>
                        <td style="background:#f7fbff; border-radius:8px; padding:16px;">

                          <p><strong>Full Name:</strong><br>
                            {{ $client->firstname }} {{ $client->middlename }} {{ $client->lastname }}</p>

                          <p><strong>Email:</strong><br>
                            {{ $user->email }}</p>

                          <p><strong>Pension Number:</strong><br>
                            {{ $user->pension_number }}</p>

                          <p><strong>PFA Selected:</strong><br>
                            {{ $client->pfa_selected ?? 'Not Selected' }}</p>

                          <p><strong>Registration ID:</strong><br>
                            {{ $client->registration_id }}</p>

                        </td>
                      </tr>
                    </table>
                  </td>

                  <!-- RIGHT (QR + BUTTON) -->
                  <td class="column" style="width:45%; text-align:center;">
                  
                  <!-- QR -->
                    @if(!empty($qrCodeSrc))
                    <div style="display:inline-block; padding:10px; background:#fff; border-radius:10px; box-shadow:0 4px 14px rgba(0,0,0,0.08);">
                      <img src="{{ $qrCodeSrc }}" width="140" height="140">
                    </div>
                    <div style="font-size:12px; margin-top:8px; color:#6b7280;">Scan to verify registration</div>
                    @endif

                    <!-- LOGIN BUTTON -->
                    <a href="{{ route('login.form') }}" 
                       class="button"
                       style="background:#10b981; color:white; margin-top:20px;">
                      🔐 Login to Portal
                    </a>

                  </td>

                </tr>
              </table>

            </td>
          </tr>

          <!-- FOOTER -->
          <tr>
            <td style="background:#f7f9fc; padding:14px; text-align:center;">
              <div style="font-size:12px; color:#6b7280;">
                © {{ now()->year }} ImperialVilla — All Rights Reserved.
              </div>
            </td>
          </tr>

        </table>

      </td>
    </tr>
  </table>

</body>
</html>
