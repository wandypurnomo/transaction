<?php


namespace Wandxx\Transaction\Services\Transaction;


use Wandxx\Transaction\Contracts\TransactionDetailRepositoryContract;
use Wandxx\Transaction\Contracts\TransactionRepositoryContract;

class MainTransactionService
{
    private $_transactionRepository;
    private $_transactionDetailRepository;
    private $_cart;

    public function __construct(
        TransactionRepositoryContract $_transactionRepository,
        TransactionDetailRepositoryContract $_transactionDetailRepository
    )
    {
        $this->_transactionRepository = $_transactionRepository;
        $this->_transactionDetailRepository = $_transactionDetailRepository;
    }

    public function getCurrentCart(string $userId): CartService
    {
        $this->_cart = $this->_transactionRepository->getCurrentCart($userId);
        return new CartService($this->_cart, $this->_transactionRepository, $this->_transactionDetailRepository);
    }

    public function getTransactionById(string $transactionId): TransactionService
    {
        $transaction = $this->_transactionRepository->find($transactionId);
        return new TransactionService($transaction, $this->_transactionRepository, $this->_transactionDetailRepository);
    }

    public function hasCart(string $userId): bool
    {
        return $this->_transactionRepository->hasCart($userId);
    }

    public function clearCart(string $userId): void
    {
        $this->_transactionRepository->clearCart($userId);
    }
}