<?php


namespace Wandxx\Transaction\Services\Transaction;


use Illuminate\Database\Eloquent\Model;
use Wandxx\Transaction\Constants\PaymentStatus;
use Wandxx\Transaction\Constants\TransactionStatus;
use Wandxx\Transaction\Contracts\TransactionDetailRepositoryContract;
use Wandxx\Transaction\Contracts\TransactionRepositoryContract;

class TransactionService
{
    private $_transactionRepository;
    private $_transactionDetailRepository;
    private $_transaction;

    public function __construct(
        Model $_transaction,
        TransactionRepositoryContract $_transactionRepository,
        TransactionDetailRepositoryContract $_transactionDetailRepository
    )
    {
        $this->_transaction = $_transaction;
        $this->_transactionRepository = $_transactionRepository;
        $this->_transactionDetailRepository = $_transactionDetailRepository;
    }

    public function setAsPlaced(): void
    {
        $this->_transactionRepository->updateTransactionStatusById($this->_transaction->id, TransactionStatus::PLACED);
    }

    public function setAsOnGoing(): void
    {
        $this->_transactionRepository->updateTransactionStatusById($this->_transaction->id, TransactionStatus::ON_GOING);
    }

    public function setAsDone(): void
    {
        $this->_transactionRepository->updateTransactionStatusById($this->_transaction->id, TransactionStatus::DONE);
    }

    public function setAsFailed(): void
    {
        $this->_transactionRepository->updateTransactionStatusById($this->_transaction->id, TransactionStatus::FAILED);
    }

    public function setAsPaid(): void
    {
        $this->_transactionRepository->updatePaymentStatusById($this->_transaction->id, PaymentStatus::PAID);
    }
}