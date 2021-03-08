<?php

namespace App\Http\Requests\Auth;

use App\Rules\Captcha;
use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class SignInRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return !Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|exists:users',
            'password' => 'required',
            'captcha' => ['required', new Captcha()],
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'Username is required',
            'username.exists' => 'User not found',
            'password.required' => 'Password is required',
            'captcha.required' => 'Captcha is required'
        ];
    }


    public function persist()
    {
        $user = User::where('username',$this->username)->first();

        if (Hash::check($this->password,$user->password)){
            Auth::login($user);
        } else {
            throw new BadRequestHttpException();
        }
    }
}
