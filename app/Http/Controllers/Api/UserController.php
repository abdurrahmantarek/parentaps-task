<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TransactionService;
use Illuminate\Support\Facades\Log;


class UserController extends Controller
{
    protected $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }
    public function index()
    {

        try {

            $transactions = $this->transactionService->getTransactions();
            return response()->json(['transactions' => $transactions], 200);

        } catch (\Exception $exception) {

            dd($exception->getMessage());

            Log::error($exception->getMessage());

            return response()->json(['error' => 'something went wrong'], 500);
        }


    }
}
