<?php


namespace Wandxx\Transaction\Contracts;


use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Wandxx\Support\Interfaces\FindableInterface;

interface TransactionRepositoryContract extends FindableInterface
{
    public function all(Request $request, ?string $userId, int $perPage = 10): LengthAwarePaginator;

    public function updatePaymentStatusById(string $transactionId, int $paymentStatus): Model;

    public function updateTransactionStatusById(string $transactionId, int $status): Model;

    public function createTransaction(string $userId, array $data): Model;

    public function getCurrentCart(string $userId): Model;

    public function hasCart(string $userId): bool;

    public function clearCart(string $userId): void;

    public function checkout(Model $transaction): Model;
}