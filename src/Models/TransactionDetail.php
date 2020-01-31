<?php


namespace Wandxx\Transaction\Models;


use Illuminate\Database\Eloquent\Model;
use Wandxx\Support\Traits\UuidForKey;

class TransactionDetail extends Model
{
    use UuidForKey;

    protected $guarded = ["id"];
    public $incrementing = false;

    protected $casts = [
        "metadata" => "array"
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}