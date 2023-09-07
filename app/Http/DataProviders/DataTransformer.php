<?php

namespace App\Http\DataProviders;


class DataTransformer {


    public static function transform($id, $email, $balance, $currency, $status, $createdAt, $dataProviderName)
    {
        return [
          'id' => $id,
          'email' => $email,
          'balance' => $balance,
          'currency' => $currency,
          'status' => $status,
          'createdAt' => $createdAt,
          'dataProviderName' => $dataProviderName,
        ];
    }

}
