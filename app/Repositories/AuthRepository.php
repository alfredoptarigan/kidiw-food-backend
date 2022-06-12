<?php

namespace App\Repositories;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthRepository
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function login($data) {
        $credential = array(
            'email' => $data['email'],
            'password' => $data['password']
        );

        if(Auth::attempt($credential)) {
            $user = Auth::user();
            $login['user'] = new UserResource($user);
            $login['token'] = Auth::user()->createToken('KidiwFood')->accessToken;
            return $login;
        }
    }

    public function register($data)
    {
        $user = $this->user->create($data);

        return new UserResource($user);
    }
}
