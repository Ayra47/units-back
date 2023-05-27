<?php

namespace App\Http\Controllers;

use App\Models\Farmer;
use Illuminate\Http\Request;

class FarmerController extends Controller
{
    public function getInfo($id)
    {
        $model = Farmer::where('id', $id)->with('products')->first();
    }
}
