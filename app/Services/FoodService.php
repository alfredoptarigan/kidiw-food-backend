<?php

namespace App\Services;

use App\Helpers\UploadHelper;
use App\Repositories\FoodRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FoodService
{
    private $repository;

    public function __construct(FoodRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAll($request) {
        return $this->repository->getAll($request);
    }

    public function create($data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'is_available' => 'boolean',
            'quantity' => 'required|integer|min:0',
            'rate_review' => 'required|numeric|min:0',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required|string',
        ]);

        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }

        if(isset($data['image'])) {
            $data['image'] = UploadHelper::upload($data['image'], 'foods');
        }

        DB::beginTransaction();

        try {
            $result = $this->repository->create($data);
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }

        DB::commit();

        return $result;
    }

    public function update($data,$food) {
        $validator = Validator::make($data, [
            'name' => 'string|max:255',
            'price' => 'numeric|min:0',
            'is_available' => 'boolean',
            'quantity' => 'integer|min:0',
            'rate_review' => 'numeric|min:0',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'string',
        ]);

        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }

        if(isset($data['image'])) {
            Storage::disk('public')->delete($food->image);
            $data['image'] = UploadHelper::upload($data['image'], 'foods');
        }

        DB::beginTransaction();
        try {
            $result = $this->repository->update($data, $food);
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();

        return $result;
    }

    public function delete($food)
    {
        DB::beginTransaction();
        try {
            Storage::disk('public')->delete($food->image);
            $result = $this->repository->delete($food);
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
        DB::commit();

        return $result;
    }

}
