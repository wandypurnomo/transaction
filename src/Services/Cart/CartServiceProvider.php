<?php


namespace Wandxx\Transaction\Services\Cart;


use Carbon\Laravel\ServiceProvider;
use Wandxx\Transaction\Contracts\TransactionDetailRepositoryContract;
use Wandxx\Transaction\Contracts\TransactionRepositoryContract;

class CartServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $cartService = new CartService(
            resolve(TransactionRepositoryContract::class),
            resolve(TransactionDetailRepositoryContract::class)
        );

        $this->app->instance(CartService::class, $cartService);
    }
}