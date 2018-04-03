<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\User\{ ChangePassword, Store as StoreUser };
use App\Repositories\UserRepository;
use App\User;

class UserController extends Controller
{
    protected $users;

    public function __construct(UserRepository $users) 
    {
        $this->middleware('auth:api')->except(['checkDuplicate', 'store']);

        $this->users = $users;
    }

    /**
     * Show the authenticated user.
     * 
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function auth(Request $request) 
    {
        return $this->users->authenticated($request->user());
    }

    /**
     * Change user's password.
     * 
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changePassword(ChangePassword $request)
    {
        return $this->users->changePassword($request);
    }

    /**
     * Check in the specified resource exists in the storage.
     * 
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function checkDuplicate(Request $request)
    {
        return $this->users->checkDuplicate($request);
    }

    /**
     * Check if password matches authenticated user's password.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function checkPassword(Request $request) 
    {
        return $this->users->checkPassword($request);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUser $request)
    {
        return $this->users->create($request);
    }
}
