<?php


namespace Wandxx\Transaction\Services\Transaction;


use Carbon\Laravel\ServiceProvider;
use Wandxx\Transaction\Contracts\TransactionDetailRepositoryContract;
use Wandxx\Transaction\Contracts\TransactionRepositoryContract;

class TransactionServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->bind("transactionService", function () {
            return new MainTransactionService(
                resolve(TransactionRepositoryContract::class),
                resolve(TransactionDetailRepositoryContract::class)
            );
        });
    }
}