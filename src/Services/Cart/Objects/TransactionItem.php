<?php


namespace Wandxx\Transaction\Services\Cart\Objects;


class TransactionItem
{
    private $_id;
    private $_name;
    private $_qty;
    private $_price;

    public function __construct(?string $_name, string $_qty, ?string $_price, ?string $id)
    {
        $this->_name = $_name;
        $this->_qty = $_qty;
        $this->_price = $_price;
        $this->_id = $id;
    }

    public function forAdd(): array
    {
        return [
            "name" => $this->_name,
            "price" => $this->_price,
            "quantity" => $this->_qty,
            "sub_total" => $this->_price * $this->_qty
        ];
    }

    public function forUpdateQty():array {
        return [
            "id" => $this->_id,
            "quantity" => $this->_qty
        ];
    }
}