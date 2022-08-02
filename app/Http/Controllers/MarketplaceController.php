<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Investor;
use App\Models\Product;
use App\Models\Warehouse;
use App\Notifications\ProductRequestNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Inertia\Inertia;

class MarketplaceController extends Controller
{
    public function index(Request $request){
        $categories = Category::all();
        $products = Product::where('active', 1)->paginate(12);
        if ($request->category) {
            $category = Category::findOrFail($request->category);
            $products = $category->products;
        }
        if ($request->showing) {
            $products = Product::where('active', 1)->take($request->showing)->paginate(12);
        }
        if ($request->sort_by) {
            switch ($request->sort_by) {
                case 'newest':
                    $products = Product::where('active', 1)->orderBy('created_at', 'desc')->paginate(12);
                    break;
                case 'oldest':
                    $products = Product::where('active', 1)->orderBy('created_at', 'asc')->paginate(12);
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

    public function detail($slug) {
        $product = Product::where('slug', $slug)->first();
        if($product) {
            $variants = $product->variants;
        }
        return Inertia::render('Marketplace/Detail', [
            'product' => $product,
            'variants' => $variants,
        ]);
    }

    public function request(Request $request) {
        $investor = Investor::where('user_id', auth()->id())->first();
        if($investor) {
            DB::table('investor_product')->insert([
                'investor_id' => $investor->id,
                'product_id' => $request->productId,
                'status' => 'request',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $product_request = DB::table('investor_product')->latest()->first();
            // $investor->notify(new ProductRequestNotification();
            Notification::send($investor, new ProductRequestNotification($product_request));
            // return $product_request;
            return 1;
        } else {
            return 0;
        }

    }

    public function products()
    {
        $products = [];
        $productIds = DB::table('investor_product')->where('investor_id', auth()->id())->get();
        // return $productIds;
        foreach ($productIds as $key => $productId) {
            $tmp_product = Product::where('id', $productId->id)->first();
            array_push($products, $tmp_product);
        }
        $investor = Investor::where('user_id', auth()->id())->first();
        // return $investor->products;
        if($investor) {
            return Inertia::render('Marketplace/Product', [
                'products' => $investor->products
            ]);
        } else {
            return "Investor don't exist";
        }
    }
}
