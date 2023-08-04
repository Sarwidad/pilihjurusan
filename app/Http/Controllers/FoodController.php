<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Http\Resources\FoodResource;
use Illuminate\Support\Facades\Validator;

class FoodController extends Controller
{
    public function index()
    {
        $foods = Food::all();
        $totalFoods = count($foods);

        $retrieved = 1;

        $formattedFoods = FoodResource::collection($foods);

        return response()->json([
            'total' => $totalFoods,
            'retrieved' => $retrieved,
            'data' => $formattedFoods,
        ]);
    }

    public function show($id)
    {
        try {
            $food = Food::findOrFail($id);
            return new FoodResource($food);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'The given food resource is not found.'], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required|integer|min:0',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $food = Food::create($request->all());
        return response()->json(['data' => new FoodResource($food)], 201);
    }

    public function update(Request $request, $id)
    {
        $food = Food::find($id);

        if (!$food) {
            return response()->json(['message' => 'The given food resource is not found.'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required|integer|min:0',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'The given data was invalid.', 'errors' => $validator->errors()], 422);
        }

        $food->update($request->all());
        return response()->json(['data' => new FoodResource($food)]);
    }

    public function destroy($id)
    {
        $food = Food::find($id);

        if (!$food) {
            return response()->json(['message' => 'The given food resource is not found.'], 404);
        }

        $food->delete();

        return response()->json(['message' => 'The food has been deleted successfully.']);
    }
}
