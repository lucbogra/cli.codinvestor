<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MarketplaceController extends Controller
{
    public function index(Request $request){
        $categories = Category::all();
        $products = Product::all();
        if ($request->category) {
            $category = Category::findOrFail($request->category);
            $products = $category->products;
        }
        return Inertia::render('Marketplace/Index', [
            'categories' => $categories,
            'products' => $products
        ]);
    }

    public function search(Request $request) {
        $products = Product::where('name', 'like', '%'.$request->keywords.'%')->get();
        return $products;
    }
}
