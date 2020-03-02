<?php


namespace Wandxx\Transaction\Services\Transaction;


use Illuminate\Support\Facades\Facade;

class TransactionServiceFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "transactionService";
    }
}