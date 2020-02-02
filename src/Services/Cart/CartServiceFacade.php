<?php


namespace Wandxx\Transaction\Services\Cart;


use Illuminate\Support\Facades\Facade;

class CartServiceFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "cartService";
    }
}