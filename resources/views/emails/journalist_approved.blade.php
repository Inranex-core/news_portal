<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Journalist Account Approved</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f8fafc; padding: 20px;">
    <div style="max-width: 550px; margin: 0 auto; background-color: #ffffff; padding: 32px; border-radius: 16px; border: 1px solid #e2e8f0;">
        <h2 style="color: #166534; margin-top: 0;">✓ Your Journalist Application Has Been Approved!</h2>
        <p style="color: #475569;">Hello {{ $user->name }},</p>
        <p style="color: #475569;">Great news! The editorial team has reviewed and approved your application to become a Journalist at <strong>{{ config('app.name') }}</strong>.</p>
        
        <p style="color: #475569;">You can now log in to your Journalist Dashboard, create articles, and submit news stories for publication.</p>

        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ route('journalist.dashboard') }}" style="background-color: #16a34a; color: #ffffff; padding: 14px 28px; font-size: 15px; font-weight: bold; text-decoration: none; border-radius: 10px; display: inline-block;">
                Go to Journalist Dashboard
            </a>
        </div>

        <hr style="border: none; border-top: 1px solid #f1f5f9; margin: 20px 0;">
        <p style="color: #94a3b8; font-size: 12px; text-align: center;">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
    </div>
</body>
</html>
