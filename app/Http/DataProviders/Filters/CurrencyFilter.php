<?php

namespace App\Http\DataProviders\Filters;


class CurrencyFilter implements IFilter{

    public function handle($transactions, $next)
    {
        if (request()->has('currency')) {

            $transactions = $transactions->where('currency', request()->get('currency'));
        }

        return $next($transactions);
    }
}
