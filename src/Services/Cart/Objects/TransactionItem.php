<?php


namespace Wandxx\Transaction\Services\Cart\Objects;


class TransactionItem
{
    private $_id;
    private $_name;
    private $_qty;
    private $_price;
    private $_components;

    public function __construct()
    {
        $this->_components = [];
    }

    public function setId(string $id): TransactionItem
    {
        $this->_id = $id;
        return $this;
    }

    public function setName(string $name): TransactionItem
    {
        $this->_name = $name;
        return $this;
    }

    public function setQty(string $qty): TransactionItem
    {
        $this->_qty = $qty;
        return $this;
    }

    public function setPrice(string $price): TransactionItem
    {
        $this->_price = $price;
        return $this;
    }

    public function setAdditionalData(array $data): TransactionItem
    {
        $this->_components = $data;
        return $this;
    }

    public function addComponent(string $key, int $value): TransactionItem
    {
        $data = compact("key", "value");
        $this->_components[] = $data;

        return $this;
    }

    public function removeComponent(string $key): TransactionItem
    {
        if (array_key_exists($key, $this->_components)) {
            unset($this->_components[$key]);
        }

        return $this;
    }

    public function forAdd(): array
    {
        $data = [
            "name" => $this->_name,
            "price" => $this->_price,
            "quantity" => $this->_qty,
            "sub_total" => ($this->_price * $this->_qty) + $this->sumComponent(),
        ];

        if (count($this->_components) > 0) {
            $data["metadata"]["additional"] = $this->_components;
        }

        return $data;
    }

    public function forUpdateQty(): array
    {
        return [
            "id" => $this->_id,
            "quantity" => $this->_qty
        ];
    }

    public function forUpdateAdditionalData():array {
        return [
            "id" => $this->_id,
            "metadata" => [
                "additional" => $this->_components
            ]
        ];
    }

    public function sumComponent(): int
    {
        $count = 0;

        foreach ($this->_components as $component) {
            $count += (int)$component["value"];
        }

        return $count;
    }
}