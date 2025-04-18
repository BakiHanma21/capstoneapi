<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <h1>Password Reset</h1>
    <p>You are receiving this email because we received a password reset request for your account.</p>
    <p>Click the button below to reset your password:</p>
    <a href="{{ $url }}" style="background-color: #4CAF50; color: white; padding: 10px 15px; text-decoration: none; display: inline-block; border-radius: 5px;">Reset Password</a>
    <p>If you did not request a password reset, no further action is required.</p>
    <p>This password reset link will expire in {{ config('auth.passwords.users.expire') }} minutes.</p>
    <p>Regards,<br>Developer</p>
</body>
</html> 