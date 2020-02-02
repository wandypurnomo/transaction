<?php


namespace Wandxx\Transaction\Services\Cart\Objects;


use Illuminate\Support\Facades\Facade;

class TransactionItemFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return TransactionItem::class;
    }
}