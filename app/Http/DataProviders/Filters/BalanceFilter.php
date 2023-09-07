<?php

namespace App\Http\DataProviders\Filters;


class BalanceFilter implements IFilter{

    public function handle($transactions, $next)
    {
        if (request()->has('balanceMin') && request()->has('balanceMax')) {

            $min = request()->get('balanceMin');
            $max = request()->get('balanceMax');

            $transactions = $transactions->filter(function ($transaction) use ($min, $max) {
                $balance = is_array($transaction) ? $transaction['balance'] : $transaction->balance;
                return $balance >= $min && $balance <= $max;
            });
        }

        return $next($transactions);
    }
}
