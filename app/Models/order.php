<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    use HasFactory;
    protected $fillable = [
        "user_id",
        "paid",
        "session_id",
        "amount"
    ];

    public function products()
    {
        return $this->hasMany(OrderProduct::class);
    }
    public function getAmountAttribute()
    {
        $amount = 0;
        foreach ($this->products as $orderProduct) {
            $amount += $orderProduct->amount;
        }
        return $amount;
    }
}