<?php


namespace Wandxx\Transaction\Objects;


class TransactionItem
{
    private $_name;
    private $_qty;
    private $_price;

    public function __construct(string $_name, string $_qty, string $_price)
    {
        $this->_name = $_name;
        $this->_qty = $_qty;
        $this->_price = $_price;

        return $this->_buildDataSet();
    }

    private function _buildDataSet(): array
    {
        return [
            "name" => $this->_name,
            "price" => $this->_price,
            "quantity" => $this->_qty,
            "sub_total" => $this->_price * $this->_qty
        ];
    }
}