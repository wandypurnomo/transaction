<?php


namespace Wandxx\Transaction\Contracts;


use Illuminate\Database\Eloquent\Model;

interface TransactionDetailRepositoryContract
{
    public function addItem(Model $transaction, array $data): Model;

    public function removeItem(Model $transaction, string $itemId): void;

    public function updateQty(Model $transaction, string $itemId, int $qty): Model;

    public function updateAdditionalData(Model $transaction, string $itemId, array $metadata): Model;
}