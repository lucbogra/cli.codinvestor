<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Location;
use App\Models\Product;
use App\Notifications\ProductRequestNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Inertia\Inertia;

class MarketplaceController extends Controller
{
  protected  $investor;

  public function __construct()
  {
    $this->middleware(function ($request, $next) {
      $this->investor = $request->user()->hasRole('Investor') ? $request->user()->investor : ($request->user()->hasRole('Member') ? $request->user()->member->investor : null);
      return $next($request);
    });
  }

  public function index(Request $request)
  {
    $products = Product::active()->filter(request()->only('search', 'country', 'category'))
      ->orderBy('created_at', 'DESC')
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

  public function detail(Product $product)
  {
    return Inertia::render('Marketplace/Detail', [
      'product' => new ProductResource($product)
    ]);
  }

  public function request(Request $request)
  {
    // dd($request->commission);
    $request->validate([
      'product_id' => ['required', 'exists:products,id'],
      'commission.price' => ['required', 'numeric'],
      'commission.commission' => ['required', 'numeric'],
      'commission' => ['required']
    ]);
    if ($this->investor) {
      $this->investor->products()->attach($request->product_id, [
        'affiliate_commission' => $request->commission['commission'],
        'affiliate_price' => $request->commission['price'],
        'commission_type' => $request->commission['commission_type'],
        'pricings' => $request->commission['commission_type'] == 'fix' ? json_encode([$request->commission]) : json_encode($request->commission['occurences']),
      ]);
      Notification::send($this->investor->manager, new ProductRequestNotification($request->product_id, $this->investor));
      return back();
    } else {
      abort(404) ;
    }
  }

  public function products(Request $request)
  {
    // dd($this->investor->accessProducts()->select('products.alias')->get()->pluck('alias')->map(function($item){return json_decode($item);})->flatten(2));
    $products = [];
    $products = $this->investor->accessProducts()
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
          'price' => $product->pivot->affiliate_price,
          'min_commission' => collect(json_decode($product->pivot->pricings))->min('commission'),
          'max_commission' => collect(json_decode($product->pivot->pricings))->max('commission'),
          'link' => $product->pivot->link,
          'pricings' => $product->pricings ? json_decode($product->pricings)->pricings : [],
          'commission_type' => $product->pivot->commission_type,
          'affiliate_commission' => $product->pivot->affiliate_commission
        ];
      });

    if ($this->investor) {
      return Inertia::render('Marketplace/Product', [
        'products' => $products
      ]);
    } else {
     abort(404);
    }
  }

  public function update(Request $request){

    $request->validate([
      'link' => ['required', 'url'],
      'product_id' => ['required', 'exists:products,id'],
      'commission.price' => ['required', 'numeric'],
      'commission.commission' => ['required', 'numeric'],
      'commission' => ['required']
    ]);

    // dd($request->all());

    $this->investor->products()->updateExistingPivot($request->product_id, [
      'link' => $request->link,
      'affiliate_commission' => $request->commission['commission'],
      'affiliate_price' => $request->commission['price'],
      'commission_type' => $request->commission['commission_type'],
      'pricings' => $request->commission['commission_type'] == 'fix' ? json_encode([$request->commission]) : json_encode($request->commission['occurences']),
    ]);

    return back()->with('success', 'Product updated.');
  }

  public function product_read_notification($notification_id, $slug){
    request()->user()->unreadNotifications->where('id', $notification_id)->markAsRead();
    return redirect()->route('marketplace.detail', $slug);
  }

  public function getuserProduct()
  {
    return response()->json($this->investor->products);
    //return response()->json(Product::all());
  }
}
