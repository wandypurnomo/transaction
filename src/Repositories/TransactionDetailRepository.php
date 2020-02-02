<?php


namespace Wandxx\Transaction\Repositories;


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
        } catch (\Exception $exception) {
            Log::debug($exception->getMessage());
        }
    }

    public function updateQty(Model $transaction, string $itemId, int $qty): Model
    {
        $item = $transaction->details()->findOrFail($itemId);
        $item->quantity = $qty;
        $item->sub_total = $qty * $item->price;
        $item->save();

        return $item;
    }

    public function updateAdditionalData(Model $transaction, string $itemId, array $metadata): Model
    {
        $item = $transaction->details()->findOrFail($itemId);
        if (array_key_exists("additional", $item->metadata)) {
            $item->update(["metadata->additional" => $metadata]);
        }
        return $item;
    }
}