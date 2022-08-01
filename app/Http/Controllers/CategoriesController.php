<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $products = Product::paginate(16);
        return view('pages.categories', [ 
            'categories' => $categories, 
            'products' => $products
        ]); 
    }

    public function detail(Request $request, $slug)
    {
        $categories = Category::all();
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = Product::where('category_id', $category->id)->paginate(16);
        return view('pages.categories', [
            'categories' => $categories,
            'products' => $products
        ]);
    }
}
