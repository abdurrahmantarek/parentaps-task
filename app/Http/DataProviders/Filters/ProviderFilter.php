<?php

namespace App\Http\DataProviders\Filters;


class ProviderFilter implements IFilter {

    public function handle($transactions, $next)
    {
        if (request()->has('provider')) {

            $transactions = $transactions->where('dataProviderName', request()->get('provider'));
        }

        return $next($transactions);
    }
}
