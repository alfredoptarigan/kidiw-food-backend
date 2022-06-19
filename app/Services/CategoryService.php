<?php

namespace App\Services;

use App\Helpers\UploadHelper;
use App\Repositories\CategoryRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CategoryService
{
    private $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAll($request)
    {
        return $this->repository->getAll($request);
    }

    public function create($data){
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if($validator->fails()){
            throw new \Exception($validator->errors()->first());
        }

        if(isset($data['icon'])){
            $data['icon'] = UploadHelper::upload($data['icon'], 'categories');
        }

        DB::beginTransaction();

        try{
            $result = $this->repository->create($data);
        } catch(\Exception $e){
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }

        DB::commit();

        return $result;
    }


}
