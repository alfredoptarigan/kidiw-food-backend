<?php

namespace App\Services;

use App\Repositories\AuthRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Helpers\UploadHelper;

class AuthService
{
    private $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function login($data)
    {
        $validator = Validator::make($data, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }

        try {
            $result = $this->authRepository->login($data);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException($e->getMessage());
        } catch (\Exception $e) {
            Log::info("Log Info : " . $e->getMessage());
            throw new \InvalidArgumentException($e->getMessage());
        }

        return $result;
    }

    public function register($data) {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            throw new  \InvalidArgumentException($validator->errors()->first());
        }

        if(isset($data['avatar'])) {
            $data['avatar'] = UploadHelper::upload($data['avatar'], 'avatars');
        }

        DB::beginTransaction();

        try {
            $result = $this->authRepository->register($data);
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \InvalidArgumentException($e->getMessage());
        }

        DB::commit();

        return $result;
    }
}
