<?php


namespace Wandxx\Transaction\Constants;


use Wandxx\Support\Interfaces\ConstantInterface;
use Wandxx\Support\Traits\HasLabel;

class PaymentStatus implements ConstantInterface
{
    use HasLabel;

    const UNPAID = 1;
    const PAID = 2;

    public function labels(): array
    {
        return [
            self::PAID => "Paid",
            self::UNPAID => "Unpaid"
        ];
    }
}