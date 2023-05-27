<?php

namespace App\Http\Controllers;

use App\Models\Farmer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['getAll','getOne', 'getFarmers']]);
    }

    public function getAll()
    {
        return response()->json([
            'success' => 1,
            'data' => Product::paginate('9')
        ]);
    }

    public function getOne($id)
    {
        $model = Product::find($id);
        if (!$model) {
            return response()->json([
                'success' => 0,
            ]); 
        }

        return response()->json([
            'success' => 1,
            'data' => $model
        ]);
    }

    public function getFarmers($farmer_id)
    {
        $model = Product::where('farmer_id', $farmer_id)->get();

        if (!$model) {
            return response()->json([
                'success' => 0,
            ]);
        }

        return response()->json([
            'success' => 1,
            'data' => $model
        ]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'price' => 'required|int',
            'user_id' => 'exists:farmer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()->toArray(),
            ]);
        }

        $farmer = Farmer::where('user_id', auth()->id())->first();
        if (!$farmer) {
            return response()->json([
                'success' => 0,
                'errors' => 'not found farmer'
            ]);
        }
        Product::create([
            'name' => $request['name'],
            'price' => $request['price'],
            'old_price' => $request['old_price'] ?? 0,
            'farmer_id' => $farmer->id
        ]);

        return response()->json([
            'success' => 1,
        ]);
    }
}
