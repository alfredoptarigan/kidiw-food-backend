<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseJson;
use App\Models\Category;
use App\Services\CategoryService;
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

        return ResponseJson::success($result, 200);
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
        //
    }

    public function update(Request $request, Category $category)
    {
        //
    }

    public function destroy(Category $category)
    {
        //
    }
}
