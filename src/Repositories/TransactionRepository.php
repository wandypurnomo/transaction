<?php


namespace Wandxx\Transaction\Repositories;


use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Wandxx\Support\Traits\FindableTrait;
use Wandxx\Support\Traits\StorableTrait;
use Wandxx\Transaction\Constants\TransactionStatus;
use Wandxx\Transaction\Contracts\TransactionRepositoryContract;

class TransactionRepository implements TransactionRepositoryContract
{
    use FindableTrait, StorableTrait;
    private $_model;

    public function __construct()
    {
        $this->_model = resolve(config("transaction.transaction_model"));
    }

    public function all(Request $request, ?string $userId, int $perPage = 10): LengthAwarePaginator
    {
        $query = $this->_model->newQuery();

        $where = function (Builder $builder) use ($request, $userId) {
            if (!is_null($userId))
                $builder->where("created_by", $userId);

            if ($request->has("code") && $request->get("code") != "")
                $builder->where("code", $request->get("code"));

            if ($request->has("status") && $request->get("status") != "") {
                $status = (int)$request->get("status");
                $builder->where("status", $status);
            }

            if ($request->get("paid") && $request->get("paid") != "") {
                $paid = (int)$request->get("paid");
                $builder->where("payment_status", $paid);
            }
        };

        $query->where($where);
        return $query->paginate($perPage);
    }

    public function updatePaymentStatusById(string $transactionId, int $paymentStatus): Model
    {
        $transaction = $this->find($transactionId);
        $transaction->update(["payment_status" => $paymentStatus]);
        return $transaction;
    }

    public function updateTransactionStatusById(string $transactionId, int $status): Model
    {
        $transaction = $this->find($transactionId);
        $transaction->update(["status" => $status]);
        return $transaction;
    }

    public function createTransaction(string $userId, array $data): Model
    {
        $data["created_by"] = $userId;
        return $this->_model->newQuery()->create($data);
    }

    public function getCurrentCart(string $userId): Model
    {
        $query = $this
            ->_model
            ->newQuery()
            ->where("status", TransactionStatus::CART)
            ->where("created_by", $userId);

        if ($query->exists()) return $query->latest()->first();
        return $this->createTransaction($userId, ["code" => Str::random()]);
    }

    public function hasCart(string $userId): bool
    {
        return $this
            ->_model
            ->newQuery()
            ->where("status", TransactionStatus::CART)
            ->where("created_by", $userId)
            ->exists();
    }

    public function clearCart(string $userId): void
    {
        $this
            ->_model
            ->newQuery()
            ->where("status", TransactionStatus::CART)
            ->where("created_by", $userId)
            ->firstOrFail()
            ->delete();
    }

    public function checkout(Model $transaction): Model
    {
        $transaction->update(["status" => TransactionStatus::WAITING_FOR_PAYMENT]);
        return $transaction;
    }
}