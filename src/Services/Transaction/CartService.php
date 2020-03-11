<?php


namespace Wandxx\Transaction\Services\Transaction;


use Exception;
use Illuminate\Database\Eloquent\Model;
use Wandxx\Transaction\Contracts\TransactionDetailRepositoryContract;
use Wandxx\Transaction\Contracts\TransactionRepositoryContract;

class CartService
{
    private $_transactionRepository;
    private $_transactionDetailRepository;
    private $_cart;

    public function __construct(
        Model $_cart,
        TransactionRepositoryContract $_transactionRepository,
        TransactionDetailRepositoryContract $_transactionDetailRepository
    )
    {
        $this->_cart = $_cart;
        $this->_transactionRepository = $_transactionRepository;
        $this->_transactionDetailRepository = $_transactionDetailRepository;
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

    public function checkout(): void
    {
        $this->_transactionRepository->checkout($this->_cart);
    }
}