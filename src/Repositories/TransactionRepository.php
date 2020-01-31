<?php


namespace Wandxx\Transaction\Repositories;


use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Wandxx\Support\Traits\FindableTrait;
use Wandxx\Support\Traits\StorableTrait;
use Wandxx\Transaction\Contracts\TransactionRepositoryContract;
use Wandxx\Transaction\Events\TransactionCreated;
use Wandxx\Transaction\Models\Transaction;

class TransactionRepository implements TransactionRepositoryContract
{
    use FindableTrait, StorableTrait;
    private $_model;

    public function __construct(Transaction $_model)
    {
        $this->_model = $_model;
    }

    public function all(Request $request, ?string $userId, int $perPage = 10): LengthAwarePaginator
    {
        $query = $this->_model->newQuery();

        $where = function (Builder $builder) use ($request, $userId) {
            if (!is_null($userId)) {
                $builder->where("created_by", $userId);
            }

            if ($request->has("code") && $request->get("code") != "") {
                $builder->where("code", $request->get("code"));
            }

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
        $model = $this->_model->newQuery()->create($data);
        event(new TransactionCreated($model));
        return $model;
    }
}