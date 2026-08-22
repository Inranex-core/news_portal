<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Email Verification OTP</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f8fafc; padding: 20px;">
    <div style="max-width: 500px; margin: 0 auto; background-color: #ffffff; padding: 30px; border-radius: 16px; border: 1px solid #e2e8f0;">
        <h2 style="color: #0f172a; margin-top: 0;">Email Verification OTP</h2>
        <p style="color: #475569;">Hello {{ $name }},</p>
        <p style="color: #475569;">Your 6-digit verification code to complete your registration is:</p>
        
        <div style="background-color: #f1f5f9; text-align: center; padding: 20px; border-radius: 12px; font-size: 32px; font-weight: bold; letter-spacing: 8px; color: #dc2626; margin: 20px 0;">
            {{ $otp }}
        </div>

        <p style="color: #64748b; font-size: 13px;">This OTP code will expire in 15 minutes. If you did not request this, please ignore this email.</p>
        <hr style="border: none; border-top: 1px solid #f1f5f9; margin: 20px 0;">
        <p style="color: #94a3b8; font-size: 12px; text-align: center;">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</body>
</html>
