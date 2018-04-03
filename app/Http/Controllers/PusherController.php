<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Pusher;

class PusherController extends Controller
{
    protected $pusher;

    public function __construct() 
    {
        $this->middleware('auth:api');

        $this->pusher = new Pusher(
            env('PUSHER_APP_KEY'), 
            env('PUSHER_APP_SECRET'), 
            env('PUSHER_APP_ID'), 
            array('cluster' => env('PUSHER_APP_CLUSTER'))
        );
    }

    /**
     * Pusher authentication end point.
     * 
     */
    public function auth(Request $request)
    {
        $this->validate($request, [
            'channel_name' => 'required|string',
            'socket_id' => 'required',
        ]);

        echo $this->pusher->socket_auth($request->channel_name, $request->socket_id);
    }
}
