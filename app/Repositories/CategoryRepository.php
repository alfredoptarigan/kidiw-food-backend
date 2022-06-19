<?php

namespace App\Repositories;

use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryRepository
{
    private $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function getAll($request){
        $query = $this->category->query();
        $page = $query->perPage($request->per_page ?? 10);
        $categories = $query->paginate($page);

        return CategoryResource::collection($categories);
    }

    public function create($data)
    {
        $category = $this->category->create($data);
        return $category;
    }

    public function update ($data, $category){
        $category->update($data);
        return new CategoryResource($category);
    }

    public function delete ($category) {
        $category->delete();
        return new CategoryResource($category);
    }
}
