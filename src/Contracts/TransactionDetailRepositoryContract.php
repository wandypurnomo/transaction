<?php


namespace Wandxx\Transaction\Contracts;


use Illuminate\Database\Eloquent\Model;

interface TransactionDetailRepositoryContract
{
    public function addItem(Model $transaction, array $data): Model;

    public function removeItem(Model $transaction, string $itemId): void;

    public function updateQty(Model $transactionDetail, int $qty): Model;

    public function updateAdditionalData(Model $transactionDetail, array $metadata): Model;
}