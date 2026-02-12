<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;



class SellerRegisterController extends Controller
{
       public function create()
    {
        return view('seller.register'); // make sure this view exists
    }    
public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:sellers,email',
            'password' => 'required|confirmed|min:8',
            'state'    => 'nullable|string',
            'district' => 'nullable|string',
            'village'  => 'nullable|string',
            'pincode'  => 'required|digits:6',
        ]);

         \App\Models\Seller::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'password'    => bcrypt($request->password),
            'state'       => $request->state,
            'district'    => $request->district,
            'village'     => $request->village,
            'pincode'     => $request->pincode,
            'is_verified' => false,
        ]);

        return redirect()->route('seller.login')
            ->with('success', 'Registration successful. Wait for admin verification.');
    }
}

