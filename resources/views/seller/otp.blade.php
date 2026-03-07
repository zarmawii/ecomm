
<div style="
    width:320px;
    margin:0 auto;
    margin-top:150px;
    border:1px solid #ccc;
    padding:20px;
    text-align:center;
">

    <p style="font-size:14px; margin-bottom:10px;">
        OTP has been sent to your registered email. Enter OTP to continue.
    </p>

    @if($errors->any())
        <div style="color:red; font-size:13px; margin-bottom:10px;">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('seller.otp.verify') }}">
        @csrf

        <input type="text"
               name="otp"
               placeholder="Enter OTP"
               style="width:100%; padding:10px; text-align:center;">

        @error('otp')
            <div style="color:red; font-size:12px;">{{ $message }}</div>
        @enderror

        <br><br>

        <button type="submit"
                style="width:100%; padding:10px; background:blue; color:white; border:none;">
            Verify OTP
        </button>
    </form>

</div>