<?php


namespace Wandxx\Transaction\Repositories;


use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Wandxx\Transaction\Contracts\TransactionDetailRepositoryContract;

class TransactionDetailRepository implements TransactionDetailRepositoryContract
{

    public function addItem(Model $transaction, array $data): Model
    {
        return $transaction->details()->create($data);
    }

    public function removeItem(Model $transaction, string $itemId): void
    {
        try {
            $transaction->details()->where("id", $itemId)->delete();
        } catch (Exception $exception) {
            Log::debug($exception->getMessage());
        }
    }

    public function updateQty(Model $transactionDetail, int $qty): Model
    {
        $item = $transactionDetail;
        $item->quantity = $qty;
        $item->sub_total = $qty * $item->price;
        $item->save();

        return $item;
    }

    public function updateAdditionalData(Model $transactionDetail, array $metadata): Model
    {
        $item = $transactionDetail;
        if (array_key_exists("additional", $item->metadata))
            $item->update(["metadata->additional" => $metadata]);
        return $item;
    }
}