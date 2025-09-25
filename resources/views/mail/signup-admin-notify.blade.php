<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
  <head>
    <title>New User Signup Alert - {{ $mailData['userName'] }}</title>
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
    <meta name="x-apple-disable-message-reformatting"> 
    <meta name="format-detection" content="telephone=no,address=no,email=no,date=no,url=no">
    <!--[if mso]>
      <noscript>
        <xml>
          <o:OfficeDocumentSettings>
            <o:AllowPNG/>
            <o:PixelsPerInch>96</o:PixelsPerInch>
          </o:OfficeDocumentSettings>
        </xml>
      </noscript>
    <![endif]-->
    <style>
      /* Clients reset */
      html, body { margin:0 !important; padding:0 !important; height:100% !important; width:100% !important; }
      * { -ms-text-size-adjust:100%; -webkit-text-size-adjust:100%; }
      table, td { mso-table-lspace:0pt !important; mso-table-rspace:0pt !important; }
      img { -ms-interpolation-mode:bicubic; border:0; outline:none; text-decoration:none; }
      a { text-decoration:none; }
      /* iOS blue links */
      a[x-apple-data-detectors],  .unstyle-auto-detected-links a,
      .aBn { border-bottom:0 !important; cursor:default !important; color:inherit !important; text-decoration:none !important; }
      /* Gmail fix */
      .a6S { display:none !important; opacity:0.01 !important; }
      /* Responsive */
      @media screen and (max-width: 600px) {
        .container { width:100% !important; }
        .stack-column, .stack-column-cell { display:block !important; width:100% !important; }
        .px-sm-24 { padding-left:24px !important; padding-right:24px !important; }
      }
      /* Dark mode basic */
      @media (prefers-color-scheme: dark) {
        body, table, .bg-light { background-color:#0b0b0b !important; }
        .text { color:#f1f5f9 !important; }
        .muted { color:#94a3b8 !important; }
        .btn { background-color:#2563eb !important; }
      }
    </style>
  </head>
  <body width="100%" style="margin:0; mso-line-height-rule:exactly; background-color:#f4f5f7;">
    <center role="article" aria-roledescription="email" lang="en" style="width:100%; background-color:#f4f5f7;">

    
      <!-- Outer container -->
      <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" style="background-color:#f4f5f7;">
        <tr>
          <td align="center">
            <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="600" class="container" style="width:600px; max-width:600px;">
              <!-- Header -->
              <tr>
                <td style="padding:24px 24px 0 24px; text-align:left;">
                  <a href="https://oec-americas.com" target="_blank" style="display:inline-block;">
                    <!-- Replace with your logo -->
                    <img src="{{ asset('front/assets/images/logo-red.png') }}" width="100" height="38" alt="OEC" style="display:block; height:auto;">
                  </a>
                </td>
              </tr>

              <!-- Card -->
              <tr>
                <td style="padding:24px;">
                  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#ffffff; border-radius:12px; box-shadow:0 2px 6px rgba(0,0,0,0.06);">
                    <tr>
                      <td class="px-sm-24" style="padding:32px 40px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, 'Noto Sans', 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', sans-serif; color:#0f172a;">
                        <h1 class="text" style="margin:0 0 12px; font-size:24px; font-weight:700; line-height:1.25;">Hello Team,</h1>
                        <p class="text" style="margin:0 0 16px; font-size:16px; line-height:1.6;">A new user has just signed up on OEC Americas. Below are the details:</p>

                        <table cellpadding="5px" cellspacing="0" border="0" style="background:#ffffff; border-radius:12px;text-align: left;">
                          <tr>
                            <th>Name:</th>
                            <td>{{ $mailData['userName'] }}</td>
                          </tr>
                          <tr>
                            <th>Email:</th>
                            <td>{{ $mailData['email'] }}</td>
                          </tr>
                          @if(!empty($mailData['phone']))
                          <tr>
                            <th>Phone:</th>
                            <td>{{ $mailData['phone'] }}</td>
                          </tr>
                          @endif
                          <tr>
                            <th>Signup Date & Time:</th>
                            <td>{{ $mailData['created_at'] }}</td>
                          </tr>
                        </table>

                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </center>
  </body>
</html>