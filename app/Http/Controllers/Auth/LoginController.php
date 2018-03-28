<?php

namespace App\Http\Controllers\Auth;

use Socialite;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use App\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @param $provider 
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @param $provider
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->user();

        $authUser = $this->findOrCreateUser($user, $provider);

        return redirect(env('APP_WEB_URL').'/#/login?token='. $authUser->createToken($provider)->accessToken);
    }

    /**
     * Determine if user exists else create a new user
     * 
     * @param $user
     * @param string $provider
     */
    protected function findOrCreateUser($user, string $provider)
    {
        $authUser = User::where('email', $user->email)->first();

        if($authUser) return $authUser;

        return User::create([
            'name' => $user->name,
            'email' => $user->email,
            'avatar' => $user->avatar,
            'provider' => $provider,
            'provider_id' => $user->id,
        ]);
    }
}
