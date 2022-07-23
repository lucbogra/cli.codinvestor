<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MarketplaceController extends Controller
{
    public function index(Request $request){
        $categories = Category::all();
        $products = Product::where('active', 1)->get();
        if ($request->category) {
            $category = Category::findOrFail($request->category);
            $products = $category->products;
        }
        if ($request->sort_by) {
            switch ($request->sort_by) {
                case 'newest':
                    $products = Product::where('active', 1)->orderBy('created_at', 'desc')->get();
                    break;

                default:
                    break;
            }
        }
        $countries = Warehouse::all()->unique('country');
        return Inertia::render('Marketplace/Index', [
            'categories' => $categories,
            'products' => $products,
            'countries' => $countries
        ]);
    }

    public function search(Request $request) {
        $products = Product::where('name', 'like', '%'.$request->keywords.'%')->get();
        return $products;
    }
}
