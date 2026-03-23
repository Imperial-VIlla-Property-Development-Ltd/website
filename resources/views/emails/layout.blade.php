<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? "ImperialVilla Notification" }}</title>
</head>

<body style="margin:0; padding:0; background:#eef1f7; font-family:Arial, sans-serif;">

    <!-- FULL BACKGROUND -->
    <table width="100%" cellpadding="0" cellspacing="0" 
           style="padding:40px 0; background:#eef1f7;">

        <tr>
            <td align="center">

                <!-- EMAIL CARD -->
                <table width="650" cellpadding="0" cellspacing="0"
                       style="background:white; border-radius:15px; overflow:hidden;
                              box-shadow:0 6px 25px rgba(0,0,0,0.20);">

                    <!-- HEADER -->
                    <tr>
                        <td align="center" 
                            style="background:#004aad; padding:25px;">
                            
                            <img src="{{ url('images/logo8.png') }}"
                                 alt="ImperialVilla"
                                 style="max-width:230px; display:block; border-radius:6px;">
                        </td>
                    </tr>

                    <!-- CONTENT AREA -->
                    <tr>
                        <td style="padding:35px; color:#333; font-size:15px;">
                            @yield('content')
                        </td>
                    </tr>

                    <!-- FOOTER -->
                    <tr>
                        <td align="center" 
                            style="background:#f4f4f4; padding:15px; 
                                   font-size:12px; color:#777;">
                            © {{ now()->year }} ImperialVilla Pension Processing Portal<br>
                            All rights reserved.
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>
