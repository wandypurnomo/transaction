<?php


namespace Wandxx\Transaction\Services\Cart;


use Carbon\Laravel\ServiceProvider;
use Wandxx\Transaction\Contracts\TransactionDetailRepositoryContract;
use Wandxx\Transaction\Contracts\TransactionRepositoryContract;

class CartServiceProvider extends ServiceProvider
{
    public function boot()
    {


        $this->app->bind("cartService",function(){
            return new CartService(
                resolve(TransactionRepositoryContract::class),
                resolve(TransactionDetailRepositoryContract::class)
            );
        });
    }
}