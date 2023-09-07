<?php

namespace App\Http\DataProviders\Filters;


class StatusCodeFilter implements IFilter {

    public function handle($transactions, $next)
    {
        if (request()->has('statusCode')) {

            $statusCode = request()->get('statusCode');

            $transactions = $transactions->where('status', $statusCode);

        }

        return $next($transactions);
    }
}
