<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\Models\UserActivation;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');

        meta()->setMeta('Reset Password');
    }

    protected function resetPassword($user, $password)
    {
        $user->forceFill([
            'password'       => bcrypt($password),
            'remember_token' => Str::random(60),
            'active'         => true,
        ])->save();

        UserActivation::where('user_id', $user->id)->delete();

        $this->guard()->login($user);
    }

    protected function rules()
    {
        return [
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|confirmed|min:6',
        ];
    }

    protected function validationErrorMessages()
    {
        return [
            'password.password_policy' => 'Choose a stronger password, at least one uppercase letter with number or symbol.',
        ];
    }
}
