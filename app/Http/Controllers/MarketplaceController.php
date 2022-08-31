<?php

namespace App\Http\Controllers;

use App\Imports\OrderImport;
use App\Models\Category;
use App\Models\Investor;
use App\Models\InvestorProduct;
use App\Models\Product;
use App\Models\Warehouse;
use App\Notifications\ProductRequestNotification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class MarketplaceController extends Controller
{
  public function index(Request $request)
  {
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

  public function search(Request $request)
  {
    $products = Product::where('name', 'like', '%' . $request->keywords . '%')->get();
    return $products;
  }

  public function detail($slug)
  {
    $product = Product::where('slug', $slug)->first();

    return Inertia::render('Marketplace/Detail', [
      'product' => [
        'id' => $product->id,
        'slug' => $product->slug,
        'name' => $product->name,
        'gallery' => $product->gallery,
        'recommanded_price' => $product->recommanded_price,
        'commission' => $product->commission,
        'description' => $product->description,
        'link' => $product->link,
        'sizes' => $product->variants()->select('size')->distinct()->get(),
        'colors' => $product->variants()->select('color')->distinct()->get(),
        'countries' =>  DB::table('products')->join('variants', 'products.id', '=', 'variants.product_id')
          ->join('supplier_products', 'variants.id', '=', 'supplier_products.variant_id')
          ->join('locations', 'locations.id', '=', 'supplier_products.location_id')
          ->where('products.id', $product->id)
          ->selectRaw('locations.country as country, sum(supplier_products.qty) as qty')
          ->groupBy('country')->get(),
        'exist_request' => Auth::user()->investor->has_requested($product->id)->select('status')->first(),
      ],

    ]);
  }

  public function request(Request $request)
  {
    $request->validate(['product_id' => ['required', 'exists:products,id']] );
    $investor = Investor::where('user_id', auth()->id())->first();
    if ($investor) {
      $investor->products()->attach($request->product_id);
      Notification::send($investor->manager, new ProductRequestNotification($request->product_id));
      return back();
    } else {
      abort(404) ;
    }
  }

  public function products(Request $request)
  {
    $products = [];
    $investor = Investor::where('user_id', auth()->id())->first();
    $products = $investor->products()->paginate(8);
    if ($request->filter_by) {
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
    if ($investor) {
      return Inertia::render('Marketplace/Product', [
        'products' => $products
      ]);
    } else {
      return "Investor don't exist";
    }
  }
}
