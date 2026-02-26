<h2>Enter Login OTP</h2>

@if($errors->any())
    <p style="color:red;">{{ $errors->first() }}</p>
@endif

<form method="POST" action="{{ route('seller.otp.verify') }}">
    @csrf

    <input type="text" name="otp" placeholder="Enter OTP">

    @error('otp')
        <div>{{ $message }}</div>
    @enderror

    <button type="submit">Verify OTP</button>
</form>