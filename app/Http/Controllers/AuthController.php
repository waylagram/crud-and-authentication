<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Auth\Events\Verified;

class AuthController extends Controller
{
    //Register user frontend with a GET request
    public function register()
    {
        return view('auth.register');
    }

    //Login user frontend with a GET request
    public function login()
    {
        return view('auth.login');
    }

    // Register user backend with a POST request
    public function registerUser(Request $request)
    {
        $validator = validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email:users',
            'phone' => 'required|string',
            'dob' => 'required',
            'gender' => 'required',
            'address' => 'required|string',
            'password' => 'required|string|confirmed|min:4|',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        $formFields = [
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'dob' => $request->input('dob'),
            'gender' => $request->input('gender'),
            'address' => $request->input('address'),
            'password' => bcrypt($request->input('password'))
        ];

        $user = User::create($formFields);

        if ($user) {
            $user->notify(new VerifyEmailNotification($user));

            Auth::login($user);
            return redirect('/')->with('success', 'Registration successful. A verification message has been sent your email');
        } else {
            return redirect()->back()->with('error', 'Registration failed');
        }
    }

    // Login user backend with a POST request
    public function loginUser(Request $request)
    {
        $validator = validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return redirect()->back()->with('error', 'Invalid credentials');
        }

        Auth::login($user);
        return redirect('/')->with('success', 'Welcome to Galaxy');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'Logout successful, see you soon');
    }

    public function passwordRequest()
    {
        return view('auth.passwords.email');
    }

    public function passwordEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        // To see user details..
        // dd($user);

        $response = Password::sendResetLink(
            $request->only('email')
        );

        if ($response == Password::RESET_LINK_SENT) {
            return redirect('/login')->with('success', 'We have e-mailed your password reset link!');
        } else {
            return redirect('/login')->with('error', 'Sorry, we are unable to reset password for the provided email address.');
        }
    }

    public function passwordReset(Request $request)
    {
        return view('auth.passwords.reset', [
            'token' => $request->token
        ]);
    }

    public function passwordUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|confirmed|min:4',
            'token' => 'required|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Invalid credentials');
        }

        $response = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = bcrypt($password);
                $user->save();
            }
        );

        if ($response == Password::PASSWORD_RESET) {
            return redirect('/login')->with('success', 'Your password has been updated!');
        } else {
            return redirect()->back()->with('error', 'Sorry, we are unable to reset password for the provided email address.');
        }
    }

    public function verify($id, Request $request)
    {
        // if(!$request->hasValidSignature()){
        //     return abort(404);
        // }

        $user = User::where('id', $id)->first();

        $user->markEmailAsVerified();

        // DISPATCH THE VERIFIED EVENT
        event(new Verified($user));

        if ($user) {
            return redirect()->route('all.posts')->with('success', 'Email verified successfully, Welcome to Galaxy!');
        } else {
            return redirect()->route('all.posts')->with('error', 'Email already verified!');
        }
    }


    // public function deactivate($id){
    //     $user = User::where('id', $id)->delete();

    //     if ($user) {
    //         return redirect('/')->with('success', 'Account deactivated');
    //     } else {
    //         return redirect('/')->with('error', 'An error has occured');
    //     }
    // }


    // public function resend()
    // {
    //     if (auth()->user()->hasVerifiedEmail()) {
    //         return redirect()->back()->with('success', 'user has already been verified');
    //     } else {
    //         auth()->user()->sendEmailVerificationNotification();
    //         return redirect()->back()->with('success', 'Email Verification Link Has Been Sent To Your Email');
    //     }
    // }
}
