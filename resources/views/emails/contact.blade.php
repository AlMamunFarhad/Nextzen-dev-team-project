<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>New Contact Message</title>
  <style>
    /* Reset styles */
    body {
      margin: 0;
      padding: 0;
      font-family: -apple-system, BlinkMacOSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
      background-color: #f4f4f9;
      color: #333333;
      line-height: 1.6;
    }
    .container {
      max-width: 400px;
      margin: 30px auto;
      background-color: #ffffff;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }
    .header {
      background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
      color: white;
      padding: 32px 40px;
      text-align: center;
    }
    .header h1 {
      margin: 0;
      font-size: 24px;
      font-weight: 600;
    }
    .content {
      padding: 40px;
    }
    .label {
      font-weight: 600;
      color: #4b5563;
      display: inline-block;
      min-width: 100px;
      margin-bottom: 4px;
    }
    .value {
      color: #1f2937;
      margin-bottom: 20px;
    }
    .message-box {
      background-color: #f9fafb;
      border-left: 4px solid #6366f1;
      padding: 20px;
      border-radius: 6px;
      white-space: pre-wrap;
      word-wrap: break-word;
    }
    .footer {
      background-color: #f1f5f9;
      padding: 24px 40px;
      text-align: center;
      font-size: 13px;
      color: #6b7280;
      border-top: 1px solid #e5e7eb;
    }
    .footer a {
      color: #4f46e5;
      text-decoration: none;
    }
    .footer a:hover {
      text-decoration: underline;
    }
    @media only screen and (max-width: 480px) {
      .content {
        padding: 24px;
      }
      .header {
        padding: 24px 20px;
      }
      .footer {
        padding: 20px;
      }
    }
  </style>
</head>
<body>

  <div class="container">
    <div class="header">
      <h1>New Contact Message</h1>
    </div>

    <div class="content">

      <p style="margin-top: 0; color: #4b5563; font-size: 15px;">
        You received a new message through the website contact form:
      </p>

      <table width="100%" cellpadding="0" cellspacing="0" style="margin: 24px 0;">
        <tr>
          <td class="label">Name:</td>
          <td class="value">{{ $data['name'] }}</td>
        </tr>
        <tr>
          <td class="label">Email:</td>
          <td class="value">
            <a href="mailto:{{ $data['email'] }}">{{ $data['email'] }}</a>
          </td>
        </tr>
        @if(!empty($data['phone']))
        <tr>
          <td class="label">Phone:</td>
          <td class="value">{{ $data['phone'] }}</td>
        </tr>
        @endif
      </table>

      <p class="label" style="margin-bottom: 8px;">Message:</p>
      <div class="message-box">
        {{ $data['message'] }}
      </div>

    </div>

    <div class="footer">
      <p>
        Received on {{ now()->format('F j, Y \a\t g:i A') }}<br>
        <a href="{{ config('app.url') }}">{{ config('app.name') }}</a>
      </p>
    </div>
  </div>

</body>
</html>
