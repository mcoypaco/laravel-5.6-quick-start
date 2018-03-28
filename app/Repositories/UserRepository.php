<?php

namespace App\Repositories;

use Hash;
use Illuminate\Http\Request;

use App\User;
use App\Events\ChangePassword;
use App\Repositories\Contracts\{ CanSearch, MustBeUnique };
use App\Repositories\Support\{ Searchable, Unique };

class UserRepository extends Repository implements CanSearch, MustBeUnique
{
    use Searchable, Unique;

    /**
     * Path for the Eloquent model.
     * 
     * @var string
     */
    protected $modelPath = 'App\User';
    
    /**
     * Path for the resource of the Eloquent model.
     * 
     * @var string
     */
    protected $resourcePath = 'App\Http\Resources\User';

    /**
     * Path for the resource collection of the Eloquent model.
     * 
     * @var string
     */
    protected $resourceCollectionPath = 'App\Http\Resources\UserCollection';

    /**
     * Column index for searching.
     * 
     * @return array
     */
    public function findBy()
    {
        return ['name', 'email'];
    }
    
    /**
     * Columns that should be unique in the storage.
     * 
     * @return array
     */
    public function uniqueBy()
    {
        return ['email'];
    }

    /**
     * Show the autheticated user's details in a resource form.
     * 
     * @param \App\User $user
     * @return \Illuminate\Http\Resources\Json\Resource
     */
    public function authenticated(User $user)
    {
        return $this->resource($user);
    }

    /**
     * Check if password matches authenticated user's password.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function checkPassword(Request $request) 
    {
        return response()->json(Hash::check($request->password, $request->user()->password));
    }

    /**
     * Change authenticated user's password.
     * 
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request)
    {
        event(new ChangePassword($request->user()));

        return response()->json(true);
    }

    public function create(Request $request)
    {
        return $this->resource(
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ])
        );
    }
}