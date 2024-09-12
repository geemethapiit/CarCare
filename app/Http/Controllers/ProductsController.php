<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {
        // Fetch all products
        $products = Product::all();

        // Pass data to view
        return view('products.index', compact('products'));
    }
}
