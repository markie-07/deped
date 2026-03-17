<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - DepEd Manager</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f0f2f5; margin: 0; padding: 0; }
        .wrapper { padding: 40px 20px; }
        .container { max-width: 550px; margin: 0 auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); border-top: 5px solid #db2777; }
        .header { padding: 30px; text-align: center; background: #f8f9fa; border-bottom: 1px solid #edf2f7; }
        .logo { max-width: 120px; height: auto; margin-bottom: 15px; }
        .content { padding: 40px; }
        .greeting { font-size: 20px; font-weight: 700; color: #1a202c; margin-bottom: 15px; }
        .message { font-size: 16px; color: #4a5568; line-height: 1.6; margin-bottom: 30px; }
        .btn-container { text-align: center; margin: 40px 0; }
        .btn { background: #db2777; color: #ffffff !important; padding: 16px 40px; border-radius: 12px; font-weight: 700; text-decoration: none; display: inline-block; box-shadow: 0 4px 14px rgba(219, 39, 119, 0.3); transition: transform 0.2s; }
        .footer { padding: 20px; text-align: center; border-top: 1px solid #edf2f7; background: #f8f9fa; }
        .footer p { font-size: 13px; color: #718096; margin: 5px 0; }
        .link-note { font-size: 11px; color: #a0aec0; margin-top: 30px; word-break: break-all; text-align: center; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="header">
                <img src="{{ $message->embed(public_path('images/SDO-Logo.png')) }}" alt="DepEd Logo" class="logo">
                <div style="font-size: 14px; color: #db2777; font-weight: 800; text-transform: uppercase;">Security Notification</div>
            </div>
            <div class="content">
                <div class="greeting">Hello!</div>
                <p class="message">We received a request to reset the password for your DepEd Manager account. If you made this request, click the button below to secure your account.</p>
                
                <div class="btn-container">
                    <a href="{{ $resetUrl }}" class="btn">Reset Password</a>
                </div>

                <p class="message">If you did not request a password reset, no further action is required. Your account remains secure.</p>
                
                <div class="link-note">
                    If you're having trouble with the button above, copy and paste the URL below into your browser:<br>
                    {{ $resetUrl }}
                </div>
            </div>
            <div class="footer">
                <p><strong>Schools Division Office - DepEd</strong></p>
                <p>&copy; 2026 DepEd Manager. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>
