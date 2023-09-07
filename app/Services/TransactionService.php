<?php

namespace App\Services;

use App\Http\DataProviders\DataProviderX;
use App\Http\DataProviders\DataProviderY;
use App\Http\DataProviders\Filters\BalanceFilter;
use App\Http\DataProviders\Filters\CurrencyFilter;
use App\Http\DataProviders\Filters\ProviderFilter;
use App\Http\DataProviders\Filters\StatusCodeFilter;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Redis;

class TransactionService
{
    protected $dataProviderX;
    protected $dataProviderY;

    public function __construct(DataProviderX $dataProviderX, DataProviderY $dataProviderY)
    {
        $this->dataProviderX = $dataProviderX;
        $this->dataProviderY = $dataProviderY;
    }

    public function getTransactions()
    {
        $data = $this->fetchData();

        return app(Pipeline::class)
            ->send($data)
            ->through([
                ProviderFilter::class,
                CurrencyFilter::class,
                BalanceFilter::class,
                StatusCodeFilter::class,
            ])
            ->thenReturn();
    }

    protected function fetchData()
    {
        $xLastModified = $this->dataProviderX->lastModified();
        $yLastModified = $this->dataProviderY->lastModified();

        if ($this->shouldUpdateCache($xLastModified, $yLastModified)) {
            return $this->updateCache($xLastModified, $yLastModified);
        }

        return collect(json_decode(Redis::get('data')));
    }

    protected function shouldUpdateCache($xLastModified, $yLastModified)
    {
        return Redis::get('data_provider_x_last_modified') != $xLastModified ||
            Redis::get('data_provider_y_last_modified') != $yLastModified ||
            Redis::get('data') === null;
    }

    protected function updateCache($xLastModified, $yLastModified)
    {
        $data = collect($this->dataProviderX->read())
            ->merge($this->dataProviderY->read());

        Redis::pipeline(function ($pipe) use ($data, $xLastModified, $yLastModified) {
            $pipe->set('data', json_encode($data));
            $pipe->set('data_provider_x_last_modified', $xLastModified);
            $pipe->set('data_provider_y_last_modified', $yLastModified);
        });

        return $data;
    }
}
