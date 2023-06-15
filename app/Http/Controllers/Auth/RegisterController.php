<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Jobs\SendActivationMail;
use App\Models\UserActivation;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    protected $group_id = 6;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        meta()->setMeta('Register');
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }

    protected function registered(Request $request, User $user)
    {
        $token = hash_hmac('sha256', $user->username . $user->email . str_random(16), config('app.key'));

        UserActivation::create([
            'user_id' => $user->id,
            'token'   => $token,
        ]);

        $this->dispatch(new SendActivationMail($user, $token));

        flash('You have been successfully registered. A confirmation email has been sent to "' . e($user->email) . '" Please confirm your email address, before you login.',
            'info');

        return redirect('login');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username'             => 'required|alpha_dash|min:3|max:20|Unique:users',
            'email'                => 'required|email|max:255|unique:users',
            'password'             => 'required|confirmed|min:8|max:48|password_policy',
            'g-recaptcha-response' => 'required|recaptcha',
        ], [
            'password.password_policy'      => 'Choose a stronger password, Minimum 8 characters and at least one uppercase letter with number or symbol.',
            'g-recaptcha-response.required' => 'Verification required',
            'recaptcha'                     => 'Verification failed. You might be a robot!',
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'group_id' => $this->group_id,
            'username' => $data['username'],
            'email'    => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }
}
