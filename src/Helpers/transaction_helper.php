<?php

if (!function_exists("getCurrentCart")) {
    function getCurrentCart(string $userId): ?\Wandxx\Transaction\Services\Cart\CartService
    {
        $cartService = resolve(\Wandxx\Transaction\Services\Cart\CartService::class);

        if ($model = $cartService instanceof \Wandxx\Transaction\Services\Cart\CartService) {
            return $cartService;
        }

        return null;
    }
}