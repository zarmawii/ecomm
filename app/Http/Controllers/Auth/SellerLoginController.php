<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Models\Seller;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerLoginController extends Controller
{
    public function create()
    {
        return view('seller.login');
    }

    public function store(Request $request)
{
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::guard('seller')->attempt([
        'email' => $credentials['email'],
        'password' => $credentials['password'],
        'is_verified' => true,
    ])) {

        $seller = Auth::guard('seller')->user();

        // Generate OTP
        $otp = random_int(100000, 999999);

        $seller->update([
            'login_otp' => $otp,
            'otp_expires_at' => Carbon::now()->addMinutes(5),
        ]);

        // Logout temporarily
        Auth::guard('seller')->logout();

        // Send OTP email (Mailtrap)
        Mail::raw("Your login OTP is: $otp", function ($message) use ($seller) {
            $message->to($seller->email)
                    ->subject('Seller Login OTP');
        });

        session(['otp_email' => $seller->email]);

return redirect()->route('seller.otp.form');
    }

    return back()->withErrors([
        'email' => 'Credentials do not match or account not verified.',
    ]);
}
public function showOtpForm()
{
    return view('seller.otp');
}

public function verifyOtp(Request $request)
{
    $request->validate([
        'otp' => 'required|digits:6',
    ]);

    $email = session('otp_email');

    if (!$email) {
        return redirect()->route('seller.login');
    }

    $seller = Seller::where('email', $email)->first();

    if (
        $seller &&
        $seller->login_otp == $request->otp &&
        now()->lessThanOrEqualTo($seller->otp_expires_at)
    ) {

        $seller->update([
            'login_otp' => null,
            'otp_expires_at' => null,
        ]);

        session()->forget('otp_email');

        Auth::guard('seller')->login($seller);

        return redirect()->route('seller.dashboard')
            ->with('success', 'Logged in successfully!');
    }

    return back()->withErrors(['otp' => 'Invalid or expired OTP']);
}

    public function destroy(Request $request)
    {
        Auth::guard('seller')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('seller.login')
                         ->with('success', 'Logged out successfully.');
    }
}
