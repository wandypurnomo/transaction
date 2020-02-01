<?php


namespace Wandxx\Transaction\Constants;


use Wandxx\Support\Interfaces\ConstantInterface;
use Wandxx\Support\Traits\HasLabel;

class TransactionType implements ConstantInterface
{
    use HasLabel;

    const DR = 1;
    const CR = 2;

    public static function labels(): array
    {
        return [
            self::DR => "Debit",
            self::CR => "Credit"
        ];
    }
}