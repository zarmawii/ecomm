<!DOCTYPE html>
<html>
<head>
    <title>Seller Verified</title>
</head>
<body>
    <h2>Hello {{ $seller->name }},</h2>

    <p>Your seller account has been <strong>verified</strong> by the admin.</p>

    <p>You can now log in and start selling your products.</p>

    <p>
        <a href="{{ route('seller.login') }}">Login Now</a>
    </p>

    <br>
    <p>Thank you,<br>
    Ecommerce Admin Team</p>
</body>
</html>
