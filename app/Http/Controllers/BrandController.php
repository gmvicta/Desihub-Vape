<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;


class BrandController extends Controller
{
    public function index()
    {
        return response()->json(Brand::select('id', 'name')->withCount('products')->get());
    }
}
