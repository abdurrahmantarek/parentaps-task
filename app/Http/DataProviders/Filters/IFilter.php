<?php

namespace App\Http\DataProviders\Filters;


interface IFilter {

    public function handle($transactions, $next);
}
