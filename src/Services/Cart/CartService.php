<?php


namespace Wandxx\Transaction\Services\Cart;


use Wandxx\Transaction\Contracts\TransactionDetailRepositoryContract;
use Wandxx\Transaction\Contracts\TransactionRepositoryContract;

class CartService
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

    public function updateQty(string $itemId, int $qty): void
    {
        $this->_transactionDetailRepository->updateQty($this->_cart, $itemId, $qty);
    }
}