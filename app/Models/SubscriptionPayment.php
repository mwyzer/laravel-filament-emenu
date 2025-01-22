<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPayment extends Model
{
    //
    protected $fillable = [
        'subscription_id',
        'proof',
        'status',
    ];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
}
