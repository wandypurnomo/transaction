<?php

use Wandxx\Transaction\Services\Transaction\TransactionService;

if (!function_exists("getCurrentCart")) {
    function getCurrentCart(string $userId): ?TransactionService
    {
        $cartService = resolve(TransactionService::class);

        if ($cartService instanceof TransactionService) {
            return $cartService->getCurrentCart($userId);
        }

        return null;
    }
}