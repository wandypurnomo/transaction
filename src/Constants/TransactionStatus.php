<?php


namespace Wandxx\Transaction\Constants;


use Wandxx\Support\Interfaces\ConstantInterface;
use Wandxx\Support\Traits\HasLabel;

class TransactionStatus implements ConstantInterface
{
    use HasLabel;

    const CART = 0;
    const PLACED = 1;
    const ON_GOING = 2;
    const DONE = 3;
    const FAILED = 4;

    public static function labels(): array
    {
        return [
            self::CART => "Cart",
            self::PLACED => "Placed",
            self::ON_GOING => "On Going",
            self::DONE => "Done",
            self::FAILED => "Failed"
        ];
    }
}