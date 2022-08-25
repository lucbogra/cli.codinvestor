<?php

namespace App\Http\Controllers;

use App\Imports\OrderImport;
use App\Models\Category;
use App\Models\Investor;
use App\Models\InvestorProduct;
use App\Models\Product;
use App\Models\Warehouse;
use App\Notifications\ProductRequestNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
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
        $rq = DB::table('products')->join('variants', 'products.id', '=', 'variants.product_id')
                                   ->join('variant_warehouse', 'variants.id', '=', 'variant_warehouse.variant_id')
                                   ->join('warehouses', 'variant_warehouse.warehouse_id', '=', 'warehouses.id')
                                   ->where('products.id', $product->id)
                                   ->select('warehouses.id', 'warehouses.name', 'warehouses.country')
                                   ->distinct()->get();

        if($product) {
            $variants = $product->variants;
        }
        return Inertia::render('Marketplace/Detail', [
            'product' => $product,
            'variants' => $variants,
            'warehouses' => $rq
        ]);
    }

    public function request(Request $request) {
        $investor = Investor::where('user_id', auth()->id())->first();
        if($investor) {
            $product_request = new InvestorProduct();
            $product_request->investor_id = $investor->id;
            $product_request->product_id = $request->productId;
            $product_request->status = 'request';
            $product_request->save();
            Notification::send($investor->manager, new ProductRequestNotification($product_request));
            // return $product_request;
            return 1;
        } else {
            return 0;
        }

    }

    public function products(Request $request)
    {
        $products = [];
        $investor = Investor::where('user_id', auth()->id())->first();
        $products = $investor->products()->paginate(8);
        if($request->filter_by) {
            switch ($request->filter_by) {
                case 'request':
                    $products = $investor->products()->where('status', 'request')->paginate(8);
                    break;
                case 'denied':
                    $products = $investor->products()->where('status', 'denied')->paginate(8);
                    break;
                case 'access':
                    $products = $investor->products()->where('status', 'access')->paginate(8);
                    break;

                default:
                    # code...
                    break;
            }
        }
        if($investor) {
            return Inertia::render('Marketplace/Product', [
                'products' => $products
            ]);
        } else {
            return "Investor don't exist";
        }
    }


}
