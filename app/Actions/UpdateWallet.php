<?php

namespace App\Actions;


class UpdateWallet
{

    public function execute($investor)
    {
        $balance=$investor->balance_histories()->sum('amount')-$investor->pendingIntegrationPayment()->sum('amount');
        $investor->wallet = $balance;
        $investor->save();
    }
}
