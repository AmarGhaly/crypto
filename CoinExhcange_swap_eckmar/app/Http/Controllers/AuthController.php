<?php

namespace App\Http\Controllers;

use App\Exchange\Utility\Captcha;
use App\Http\Requests\Auth\SignInRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function signInShow()
    {
        return view('admin.login')->with([
            'captcha' => Captcha::Build()
        ]);
    }

    public function signInPost(SignInRequest $request)
    {
        try {
            $trade = $request->persist();
            return redirect()->route('home');
        } catch (\Exception $exception) {
            Log::error($exception);
            session()->flash('error', 'Cloud not sign in');
            return redirect()->back();
        }
    }

    public function signOut()
    {
        auth()->logout();
        session()->flush();
        return redirect()->route('home');
    }
}
