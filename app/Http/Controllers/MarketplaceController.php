<?php

namespace App\Http\Controllers;

use App\Imports\OrderImport;
use App\Models\Category;
use App\Models\Investor;
use App\Models\InvestorProduct;
use App\Models\Location;
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
    // $categories = Category::all();
    // $products = Product::where('active', 1)->paginate(12);
    // if ($request->category) {
    //   $category = Category::findOrFail($request->category);
    //   $products = $category->products;
    // }
    // if ($request->showing) {
    //   $products = Product::where('active', 1)->take($request->showing)->paginate(12);
    // }
    // if ($request->sort_by) {
    //   switch ($request->sort_by) {
    //     case 'newest':
    //       $products = Product::where('active', 1)->orderBy('created_at', 'desc')->paginate(12);
    //       break;
    //     case 'oldest':
    //       $products = Product::where('active', 1)->orderBy('created_at', 'asc')->paginate(12);
    //       break;
    //     default:
    //       break;
    //   }
    // }

    $products = Product::active()->filter(request()->only('search', 'country', 'category'))
      ->paginate(request()->paginate ?? 12)
      ->withQueryString()
      ->through(function ($product) {
        return [
          'slug' => $product->slug,
          'name' => $product->name,
          'photo' => $product->photo,
          'recommanded_price' => $product->recommanded_price,
          'commission' => $product->commission,
        ];
    });

    // dd($products);


    $countries = Location::select('id','country')->get();
    $categories = Category::select('id', 'name')->get();


    return Inertia::render('Marketplace/Index', [
      'filters' => request()->only('search', 'country', 'category', 'paginate'),
      'products' => $products,
      'countries' => $countries,
      'categories' => $categories,
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

    $products = $investor->products()->wherePivot('status', 'access')
      ->paginate(10)
      ->withQueryString()
      ->through(function ($product){
        return [
          'id' => $product->id,
          'name' => $product->name,
          'sku' => $product->pivot->status == 'access' ? $product->sku : null,
          'photo' => $product->photo,
          'slug' => $product->slug,
          'categories' => $product->categories->pluck('name'),
          'recommanded_price' => $product->recommanded_price,
          'commission' => $product->commission,
          'link' => $product->pivot->link,
        ];
      });

    if ($investor) {
      return Inertia::render('Marketplace/Product', [
        'products' => $products
      ]);
    } else {
     abort(404);
    }
  }

  public function update_link(Request $request){
    $request->validate([
      'link' => ['required', 'url'],
      'product_id' => ['required', 'exists:products,id']
    ]);

    auth()->user()->investor->products()->updateExistingPivot($request->product_id, ['link' => $request->link]);

    return back()->with('success', 'Link updated.');
  }
}
