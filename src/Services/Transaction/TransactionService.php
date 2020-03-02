<?php


namespace Wandxx\Transaction\Services\Transaction;


use Exception;
use Wandxx\Transaction\Constants\PaymentStatus;
use Wandxx\Transaction\Constants\TransactionStatus;
use Wandxx\Transaction\Contracts\TransactionDetailRepositoryContract;
use Wandxx\Transaction\Contracts\TransactionRepositoryContract;

class TransactionService
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

    public function getCurrentCart(string $userId): TransactionService
    {
        $this->_cart = $this->_transactionRepository->getCurrentCart($userId);
        return $this;
    }

    public function addCart(array $data): void
    {
        $this->_transactionDetailRepository->addItem($this->_cart, $data);
    }

    public function removeCart(string $itemId): void
    {
        $this->_transactionDetailRepository->removeItem($this->_cart, $itemId);
    }

    public function updateQty(array $data): void
    {
        throw_if(
            !array_key_exists("quantity", $data),
            new Exception("required data not satisfied.")
        );

        $this->_transactionDetailRepository->updateQty($this->_cart, $data["quantity"]);
    }

    public function updateAdditionalData(array $data): void
    {
        throw_if(
            !array_key_exists("metadata", $data),
            new Exception("required data not satisfied.")
        );

        $this->_transactionDetailRepository->updateAdditionalData($this->_cart, $data["metadata"]);
    }

    public function hasCart(string $userId): bool
    {
        return $this->_transactionRepository->hasCart($userId);
    }

    public function clearCart(string $userId): void
    {
        $this->_transactionRepository->clearCart($userId);
    }

    public function checkout(): void
    {
        $this->_transactionRepository->checkout($this->_cart);
    }

    public function setAsPlaced(string $transactionId): void
    {
        $this->_transactionRepository->updateTransactionStatusById($transactionId, TransactionStatus::PLACED);
    }

    public function setAsOnGoing(string $transactionId): void
    {
        $this->_transactionRepository->updateTransactionStatusById($transactionId, TransactionStatus::ON_GOING);
    }

    public function setAsDone(string $transactionId): void
    {
        $this->_transactionRepository->updateTransactionStatusById($transactionId, TransactionStatus::DONE);
    }

    public function setAsFailed(string $transactionId): void
    {
        $this->_transactionRepository->updateTransactionStatusById($transactionId, TransactionStatus::FAILED);
    }

    public function setAsPaid(string $transactionId): void
    {
        $this->_transactionRepository->updatePaymentStatusById($transactionId, PaymentStatus::PAID);
    }
}