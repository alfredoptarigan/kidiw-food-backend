<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ResponseJson;
use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $authService;
    private $requestLogin = [
        'email',
        'password',
    ];

    private $requestRegister = [
        'name',
        'email',
        'password',
        'avatar'
    ];

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request)
    {
            $data = $request->only($this->requestLogin);
        try {
            $result = $this->authService->login($data);
        } catch(ModelNotFoundException){
            return ResponseJson::error('Email or password is incorrect');
        }
        catch (\Exception $e) {
            return ResponseJson::error($e->getMessage(), 400);
        }

        return $result;
    }

    public function register(Request $request)
    {
        $data = $request->only($this->requestRegister);

        try {
            $result = $this->authService->register($data);
        } catch (\Exception $e) {
            return ResponseJson::error('General error : ' . $e->getMessage(), 500);
        }

        return ResponseJson::success($result, 'Register success');
    }
}
