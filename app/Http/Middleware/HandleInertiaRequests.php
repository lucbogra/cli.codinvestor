<?php

namespace App\Http\Middleware;

use App\Models\Product;
use App\Models\WebSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;
use Laravel\Sanctum\PersonalAccessToken;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request): array
    {
      $requests_notifications = $request->user() ? $request->user()->unreadNotifications->where('type', 'App\Notifications\ProductAccessNotification')->map(function ($notification){
        return[
          'id' => $notification->id,
          'text' => 'Your request for the product '.$notification->data['name'].' was '.$notification->data['message'],
          'created_at' => Carbon::parse($notification->created_at)->diffForHumans(),
          'link' => route('marketplace.products.read_notification', [$notification->id, Product::find($notification->data['id'])->slug]),
          'icon' => $notification->data['message'] == 'accepted' ? 'fa-solid fa-shop fa-lg text-success' : 'fa-solid fa-shop-slash fa-lg text-danger',
          'type' => 'Product Request'
        ];
      }) : null;
      $invoices_notifications = $request->user() ? $request->user()->unreadNotifications->where('type', 'App\Notifications\InvoiceNotification')->map(function ($notification){
        return[
          'id' => $notification->id,
          'text' => 'weekly invoice number #'.$notification->data['slug'].'. See the details.',
          'created_at' => Carbon::parse($notification->created_at)->diffForHumans(),
          'link' => route('invoice.notification.show', [$notification->id, $notification->data['slug']]),
          'icon' => 'fa-solid fa-file-invoice-dollar text-primary-500',
          'type' => 'Weekly Invoice'
        ];
      }) : null;
      $paid_notifications = $request->user() ? $request->user()->unreadNotifications->where('type', 'App\Notifications\InvoicePaid')->map(function ($notification){
        return[
          'id' => $notification->id,
          'text' => 'Your invoice #'.$notification->data['slug'].' was paid. See the details.',
          'created_at' => Carbon::parse($notification->created_at)->diffForHumans(),
          'link' => route('invoice.notification.show', [$notification->id, $notification->data['slug']]),
          'icon' => 'fa-solid fa-file-invoice-dollar text-success',
          'type' => 'Invoice Paid'
        ];
      }) : null;
      $new_fundings = $request->user() ? $request->user()->unreadNotifications->where('type', 'App\Notifications\FundingCreationNotification')->map(function ($notification){
        return[
          'id' => $notification->id,
          'text' => $notification->data['text'],
          'created_at' => Carbon::parse($notification->created_at)->diffForHumans(),
          'link' => route('fundings.index'),
          'icon' => 'fa-sharp fa-solid fa-receipt text-secondary',
          'type' => 'New Funding'
        ];
      }) : null;

      $answers = $request->user() ? $request->user()->unreadNotifications->where('type', 'App\Notifications\CreativeNotification')->map(function ($notification){
        return[
          'id' => $notification->id,
          'text' => $notification->data['message'],
          'created_at' => Carbon::parse($notification->created_at)->diffForHumans(),
          'link' => route($notification->data['route'],$notification->data['id']),
          'icon' => 'fa-sharp fa-solid fa-video text-danger',
          'type' => 'New Funding'
        ];
      }) : null;

    return array_merge(parent::share($request), [
      'flash' => function () use ($request) {
        return [
          'success' => $request->session()->get('success'),
          'error' => $request->session()->get('error'),
        ];
      },
      'auth' => function () use ($request) {
        // $token = $request->user() ? PersonalAccessToken::where('tokenable_id', Auth::user()->investor->id)->orderby('created_at', 'desc')->first('name') : null;
            return [
              'user' => $request->user() ? [
                'ip' => $_SERVER['REMOTE_ADDR'],
                'role' => $request->user()->role,
                'permissions' => $request->user()->getAllPermissions()->pluck('name'),
                'balance' => $request->user()->investor?->wallet,
                'funding' => $request->user()->investor?->funding,
                'seller_status' => $request->user()->investor?->seller_status,
              ] : null,
            ];
          },
          'logo' => WebSetting::first()->logo_white,
          'logo_color' => WebSetting::first()->logo,
          'notifications' => $request->user() ? $requests_notifications->union($invoices_notifications)->union($paid_notifications)->union($new_fundings)->union($answers) : null,
          'message_notifications' => $request->user() ? $request->user()->messages()->wherePivot('read_at', null)->count() : null,
          'not_readed_responses'=>$request->user() ? $request->user()->unreadNotifications->where('type', 'App\Notifications\CreativeNotification')->count() : null
        ]);
    }
}
