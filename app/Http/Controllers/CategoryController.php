<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseJson;
use App\Http\Resources\FoodResource;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $service;
    private $request = [
        'name',
        'icon'
    ];

    public function __construct(CategoryService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        try {
            $result = $this->service->getAll($request);
        } catch (\Exception $e) {
            return ResponseJson::error($e->getMessage(),400);
        }

        return $result;
    }


    public function store(Request $request)
    {
        $data = $request->only($this->request);

        try {
            $food = $this->service->create($data);
        } catch (\Exception $e) {
            return ResponseJson::error($e->getMessage(), 400);
        }

        return ResponseJson::success($food, 'Success created category');
    }

    public function show(Category $category)
    {
        try {
            return new FoodResource($category);
        } catch(ModelNotFoundException $e) {
            return ResponseJson::error("Category not found", 404);
        }
        catch (\Exception $e) {
            return ResponseJson::error($e->getMessage(), 400);
        }
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->only($this->request);

        try {
            $result = $this->service->update( $data  , $category) ;
        } catch (\Exception $e) {
            return ResponseJson::error($e->getMessage(), 400);
        }

        return ResponseJson::success($result, 'Success updated category');
    }

    public function destroy(Category $category)
    {
        try {
            $result = $this->service->delete($category);
        } catch (\Exception $e) {
            return ResponseJson::error($e->getMessage(), 400);
        }

        return ResponseJson::success($result, 'Success deleted category');
    }
}
