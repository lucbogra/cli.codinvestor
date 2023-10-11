<?php

namespace App\Http\Controllers;

use App\Repositories\FundingRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;
use \App\Models\Notification;

class FundingController extends Controller
{
  public function __construct(FundingRepository $fundingRepository)
  {
    $this->fundingRepository = $fundingRepository;
  }

  public function index(){
    return Inertia::render('Fundings/Index', [
      'fundings' => $this->fundingRepository->all()
    ]);
  }

  public function readWalletNotification(Notification $notification)
  {
    $notification->markAsRead();
    return back();
  }
}
