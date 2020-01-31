<?php


namespace Wandxx\Transaction\Providers;


use Illuminate\Support\ServiceProvider;
use Wandxx\Transaction\Contracts\TransactionDetailRepositoryContract;
use Wandxx\Transaction\Contracts\TransactionRepositoryContract;
use Wandxx\Transaction\Repositories\TransactionDetailRepository;
use Wandxx\Transaction\Repositories\TransactionRepository;

class TransactionServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->_publishing();
    }

    public function boot(): void
    {
        $this->_registerConfig();
        $this->_bindRepository();
    }

    private function _registerConfig(): void
    {
        if (file_exists(config_path("transaction.php"))) {
            $this->mergeConfigFrom(__DIR__ . config_path("transaction.php"), "transaction");
        } else {
            $this->mergeConfigFrom(__DIR__ . "/../Configs/transaction.php", "transaction");
        }
    }

    private function _publishing(): void
    {
        $this->publishes([
            __DIR__ . "/../Migrations" => database_path("migrations")
        ], "migrations");

        $this->publishes([
            __DIR__ . "/../Configs/transaction.php" => config_path("config.php")
        ], "config");
    }

    private function _bindRepository(): void
    {
        $this->app->register(TransactionRepositoryContract::class, TransactionRepository::class);
        $this->app->register(TransactionDetailRepositoryContract::class, TransactionDetailRepository::class);
    }
}