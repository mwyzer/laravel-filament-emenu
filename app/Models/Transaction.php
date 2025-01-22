<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'code',
        'name',
        'whatsapp',
        'payment_method',
        'total_price',
        'payment_status',
    ];

    public static function boot()
    {
        parent::boot();

        if (Auth::check()) {
            static::creating(function ($model) {
                if (Auth::user()->role === 'store') {
                    $model->user_id = Auth::user()->id;
                }
            });
        }

        static::updating(function ($model) {
            if (Auth::check() && Auth::user()->role === 'store') {
                $model->user_id = Auth::id();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}
