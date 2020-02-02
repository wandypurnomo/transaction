<?php

if (!function_exists("getCurrentCart")) {
    function getCurrentCart(string $userId): ?\Illuminate\Database\Eloquent\Model
    {
        $cartService = resolve(\Wandxx\Transaction\Services\Cart\CartService::class);

        if ($model = $cartService->getCurrentCart($userId) instanceof \Illuminate\Database\Eloquent\Model) {
            return $cartService->getCurrentCart($userId);
        }

        return null;
    }
}