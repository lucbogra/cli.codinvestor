<?php

namespace App\Http\Middleware;

use App\Models\Product;
use App\Models\WebSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;

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
        ];
      }) : null;
      $invoices_notifications = $request->user() ? $request->user()->unreadNotifications->where('type', 'App\Notifications\InvoiceNotification')->map(function ($notification){
        return[
          'id' => $notification->id,
          'text' => 'weekly invoice number #'.$notification->data['slug'].'. See the details.',
          'created_at' => Carbon::parse($notification->created_at)->diffForHumans(),
          'link' => route('invoice.notification.show', [$notification->id, $notification->data['slug']]),
        ];
      }) : null;
      $paid_notifications = $request->user() ? $request->user()->unreadNotifications->where('type', 'App\Notifications\InvoicePaid')->map(function ($notification){
        return[
          'id' => $notification->id,
          'text' => 'Your invoice #'.$notification->data['slug'].' was paid. See the details.',
          'created_at' => Carbon::parse($notification->created_at)->diffForHumans(),
          'link' => route('invoice.notification.show', [$notification->id, $notification->data['slug']]),
        ];
      }) : null;

        return array_merge(parent::share($request), [
            'flash' => function () use ($request) {
                return [
                    'success' => $request->session()->get('success'),
                    'error' => $request->session()->get('error'),
                ];
            },
            'balance' => $request->user() ? $request->user()->investor->wallet : null,
            'logo' => WebSetting::first()->logo_white,
            'logo_color' => WebSetting::first()->logo,
            'notifications' => $request->user() ? $requests_notifications->union($invoices_notifications)->union($paid_notifications) : null,
        ]);
    }
}
