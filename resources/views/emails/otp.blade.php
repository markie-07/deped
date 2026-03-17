<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification Code - DepEd Manager</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f0f2f5; margin: 0; padding: 0; }
        .wrapper { padding: 40px 20px; }
        .container { max-width: 550px; margin: 0 auto; background: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); border-top: 5px solid #004a8e; }
        .header { padding: 30px; text-align: center; background: #f8f9fa; border-bottom: 1px solid #edf2f7; }
        .logo { max-width: 120px; height: auto; margin-bottom: 15px; }
        .content { padding: 40px; }
        .greeting { font-size: 20px; font-weight: 700; color: #1a202c; margin-bottom: 15px; }
        .message { font-size: 16px; color: #4a5568; line-height: 1.6; margin-bottom: 30px; }
        .otp-box { background: #f1f7ff; border: 2px dashed #004a8e; border-radius: 12px; padding: 25px; text-align: center; margin: 30px 0; }
        .otp-label { font-size: 13px; font-weight: 600; color: #004a8e; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 10px; display: block; }
        .otp-code { font-size: 42px; font-weight: 800; color: #1a202c; letter-spacing: 0.15em; font-family: 'Courier New', Courier, monospace; margin: 0; }
        .footer { padding: 20px; text-align: center; border-top: 1px solid #edf2f7; background: #f8f9fa; }
        .footer p { font-size: 13px; color: #718096; margin: 5px 0; }
        .security-note { font-size: 14px; color: #718096; font-style: italic; text-align: center; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="header">
                <img src="{{ $message->embed(public_path('images/SDO-Logo.png')) }}" alt="DepEd Logo" class="logo">
                <div style="font-size: 14px; color: #004a8e; font-weight: 800; text-transform: uppercase;">DepEd Manager System</div>
            </div>
            <div class="content">
                <div class="greeting">Hello, {{ $userName }}!</div>
                <p class="message">To continue with your login, please enter the following verification code in the portal. For security purposes, this code will expire in <strong style="color: #004a8e;">5 minutes</strong>.</p>
                
                <div class="otp-box">
                    <span class="otp-label">Verification Code</span>
                    <h1 class="otp-code">{{ $otp }}</h1>
                </div>

                <p class="security-note">If you did not attempt to sign in, please secure your account or notify the administrator immediately.</p>
            </div>
            <div class="footer">
                <p><strong>Schools Division Office - DepEd</strong></p>
                <p>&copy; 2026 DepEd Manager. All rights reserved.</p>
            </div>
        </div>
    </div>
</body>
</html>
