<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseJson;
use App\Http\Resources\FoodResource;
use App\Models\Food;
use App\Services\FoodService;
use http\Env\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    private $foodService;
    private $request = [
        'name',
        'stock',
        'price',
        'is_availablel',
        'quantity',
        'rate_review',
        'image',
        'description',
    ];

    public function __construct(FoodService $service)
    {
        $this->foodService = $service;
    }

    public function index(Request $request)
    {
        try {
            $result = $this->foodService->getAll($request);
        } catch (\Exception $e) {
            return ResponseJson::error($e->getMessage(),400);
        }

        return $result;
    }

    public function store(Request $request)
    {
        $data = $request->only($this->request);

        try {
            $food = $this->foodService->create($data);
        } catch (\Exception $e) {
        return ResponseJson::error($e->getMessage(), 400);
        }

        return ResponseJson::success($food, 'Success created food');
    }

    public function show(Food $food)
    {
        try {
            return new FoodResource($food);
        } catch(ModelNotFoundException $e){
            return ResponseJson::error("Food not found", 404);
        } catch(\Exception $e){
            return ResponseJson::error($e->getMessage(), 400);
        }
    }


    public function update(Request $request, Food $food)
    {
        $data = $request->only($this->request);

        try {
            $result = $this->foodService->update($data, $food);
        } catch(ModelNotFoundException $e){
            return ResponseJson::error("Food not found",404);
        }
        catch (\Exception $e) {
            return ResponseJson::error($e->getMessage(), 400);
        }

        return ResponseJson::success($result, 'Success updated food');
    }

    public function destroy(Food $food)
    {
        try {
            $result = $this->foodService->delete($food);
        } catch (\Exception $e) {
            return ResponseJson::error($e->getMessage(), 400);
        }

        return ResponseJson::success($result, 'Success deleted food');
    }
}
