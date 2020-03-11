<?php

use Wandxx\Transaction\Services\Transaction\MainTransactionService;

if (!function_exists("getCurrentCart")) {
    function getCurrentCart(string $userId): ?MainTransactionService
    {
        $cartService = resolve(MainTransactionService::class);

        if ($cartService instanceof MainTransactionService) {
            return $cartService->getCurrentCart($userId);
        }

        return null;
    }
}