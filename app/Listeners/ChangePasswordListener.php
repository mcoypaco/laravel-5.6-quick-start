<?php

namespace App\Listeners;

use App\Events\ChangePassword;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;

class ChangePasswordListener
{
    protected $user;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->user = $request->user();
    }

    /**
     * Handle the event.
     *
     * @param  ChangePassword  $event
     * @return void
     */
    public function handle(ChangePassword $event)
    {
        $this->removeTemporaryPasswordNotification()->changeUserPassword()->removeAllTokens();
    }

    /**
     * Remove all temporary password notification
     * 
     */
    protected function removeTemporaryPasswordNotification() 
    {
        $this->user->unreadNotifications()->where('type', 'App\Notifications\SendTemporaryPassword')->delete();

        return $this;
    }

    /**
     * Change the user's password.
     * 
     */
    protected function changeUserPassword()
    {
        $this->user->password = bcrypt(request()->password);

        $this->user->save();

        return $this;
    }

    /**
     * Remove all tokens of the user.
     * 
     */
    protected function removeAllTokens() 
    {
        $this->user->tokens()->each(function($token) {
            $token->delete();
        });

        return $this;
    }
}
