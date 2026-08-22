<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Journalist Account Invitation</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f8fafc; padding: 20px;">
    <div style="max-width: 550px; margin: 0 auto; background-color: #ffffff; padding: 32px; border-radius: 16px; border: 1px solid #e2e8f0;">
        <h2 style="color: #0f172a; margin-top: 0;">Official Invitation to Join as Journalist</h2>
        <p style="color: #475569;">Hello {{ $user->name }},</p>
        <p style="color: #475569;">You have been officially invited by the editorial team to join <strong>{{ config('app.name') }}</strong> as an accredited Journalist.</p>
        
        <p style="color: #475569;">Please click the button below to set up your account password and activate your Journalist Dashboard:</p>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ $inviteUrl }}" style="background-color: #dc2626; color: #ffffff; padding: 14px 28px; font-size: 15px; font-weight: bold; text-decoration: none; border-radius: 10px; display: inline-block;">
                Activate Journalist Account
            </a>
        </div>

        <p style="color: #64748b; font-size: 13px;">Or copy and paste this link into your browser:<br>
        <a href="{{ $inviteUrl }}" style="color: #dc2626;">{{ $inviteUrl }}</a></p>
        
        <hr style="border: none; border-top: 1px solid #f1f5f9; margin: 20px 0;">
        <p style="color: #94a3b8; font-size: 12px; text-align: center;">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</body>
</html>
