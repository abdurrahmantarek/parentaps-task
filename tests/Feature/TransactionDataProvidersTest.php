<?php

namespace Tests\Feature;

use Tests\TestCase;

class TransactionDataProvidersTest extends TestCase
{

    public function test_retrieve_data_from_data_providers(): void
    {

        $response = $this->get('api/v1/users');
        $response->assertJsonIsArray('transactions');
        $response->assertStatus(200);
    }

    public function test_filter_by_provider_data_provider_x(): void
    {
        $response = $this->get('api/v1/users?provider=DataProviderX');
        $response->assertSeeText('transactions');
        $response->assertStatus(200);

        $transactions = $response->json('transactions');
        if (!empty($transactions)) {
            $response->assertSee('DataProviderX');
        }
    }

    public function test_filter_by_provider_data_provider_y(): void
    {
        $response = $this->get('api/v1/users?provider=DataProviderY');
        $response->assertSeeText('transactions');
        $response->assertStatus(200);

        $transactions = $response->json('transactions');

        if (!empty($transactions)) {
            $response->assertSee('DataProviderY');
        }
    }


    public function test_filter_by_status_code_authorised(): void
    {
        $response = $this->get('api/v1/users?statusCode=authorised');
        $response->assertSee('transactions');
        $response->assertStatus(200);

        $transactions = $response->json('transactions');

        if (!empty($transactions)) {
            $response->assertSee('authorised');
        }

    }

    public function test_filter_by_status_code_decline(): void
    {
        $response = $this->get('api/v1/users?statusCode=decline');
        $response->assertSee('transactions');
        $response->assertStatus(200);

        $transactions = $response->json('transactions');

        if (!empty($transactions)) {
            $response->assertSee('decline');
        }

    }

    public function test_filter_by_status_code_refunded(): void
    {
        $response = $this->get('api/v1/users?statusCode=refunded');
        $response->assertSee('transactions');
        $response->assertStatus(200);

        $transactions = $response->json('transactions');

        if (!empty($transactions)) {
            $response->assertSee('refunded');
        }

    }

    public function test_filter_by_amount_range(): void
    {
        $response = $this->get('api/v1/users?balanceMin=10&balanceMax=100');
        $response->assertSee('transactions');
        $response->assertStatus(200);

        $transactions = $response->json('transactions');

        if (isset($transactions) && is_array($transactions)) {
            foreach ($transactions as $transaction) {
                if ($transaction['balance'] < 10 || $transaction['balance'] > 100) {

                    $this->assertFalse(true, 'A number outside the range 10-100 was found.');
                }
            }
        }

    }

    public function test_filter_by_currency(): void
    {
        $response = $this->get('api/v1/users?currency=USD');
        $response->assertStatus(200);

        $transactions = $response->json('transactions');

        if (!empty($transactions)) {
            $response->assertSee('USD');
        }
    }

    public function test_combining_multiple_filters(): void
    {
        $response = $this->get('api/v1/users?provider=DataProviderX&statusCode=authorised&balanceMin=10&balanceMax=100&currency=USD');
        $response->assertStatus(200);


        $transactions = $response->json('transactions');

        if (!empty($transactions)) {
            $response->assertSee('USD');
            $response->assertSee('authorised');
            $response->assertSee('DataProviderX');

            foreach ($transactions as $transaction) {
                if ($transaction['balance'] < 10 || $transaction['balance'] > 100) {
                    $this->assertFalse(true, 'A number outside the range 10-100 was found.');
                }
            }
        }

    }

}
