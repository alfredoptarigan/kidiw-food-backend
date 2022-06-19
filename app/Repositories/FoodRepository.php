<?php

namespace App\Repositories;

use App\Http\Resources\FoodResource;
use App\Models\Food;

class FoodRepository
{
    private $food;

    public function __construct(Food $food)
    {
        $this->food = $food;
    }

    public function getAll($request) {
        $query = $this->food->query();
        $page = $query->perPage($request->per_page ?? 10);
        $foods = $query->paginate($page);

        return FoodResource::collection($foods);
    }

    public function create($data) {
        $food = $this->food->create($data);
        return new FoodResource($food);
    }

    public function update($data, $food) {
        $food->update($data);
        return new FoodResource($food);
    }

    public function delete($food) {
       $food->delete();
        return new FoodResource($food);
    }
}
