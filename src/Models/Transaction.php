<?php


namespace Wandxx\Transaction\Models;


use Envant\Fireable\FireableAttributes;
use Illuminate\Database\Eloquent\Model;
use Wandxx\Support\Traits\UuidForKey;
use Wandxx\Transaction\Constants\PaymentStatus;
use Wandxx\Transaction\Constants\TransactionStatus;
use Wandxx\Transaction\Events\TransactionCheckedOut;
use Wandxx\Transaction\Events\TransactionCreated;
use Wandxx\Transaction\Events\TransactionDone;
use Wandxx\Transaction\Events\TransactionFailed;
use Wandxx\Transaction\Events\TransactionOnGoing;
use Wandxx\Transaction\Events\TransactionPaid;
use Wandxx\Transaction\Events\TransactionPlaced;

class Transaction extends Model
{
    use UuidForKey, FireableAttributes;

    protected $guarded = ["id"];
    public $incrementing = false;
    protected $casts = [
        "metadata" => "array"
    ];

    protected $fireableAttributes = [
        "status" => [
            TransactionStatus::PLACED => TransactionPlaced::class,
            TransactionStatus::ON_GOING => TransactionOnGoing::class,
            TransactionStatus::DONE => TransactionDone::class,
            TransactionStatus::FAILED => TransactionFailed::class,
            TransactionStatus::WAITING_FOR_PAYMENT => TransactionCheckedOut::class,
        ],
        "payment_status" => [
            PaymentStatus::PAID => TransactionPaid::class,
        ],
    ];

    public function details()
    {
        return $this->hasMany(config("transaction.transaction_detail_model"), "transaction_id");
    }

    protected static function boot()
    {
        self::created(function (Model $model) {
            event(new TransactionCreated($model));
        });
    }
}