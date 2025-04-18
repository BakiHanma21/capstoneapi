<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $primaryKey = 'transaction_id';
    public $incrementing = false;
    protected $perPage = 20;

    protected $fillable = [
        'transaction_id',
        'request_id',
        'name',
        'customer_id',
        'payment_status',
        'payment_date',
        'amount',
        'title',
        'review',
        'rating',
        'review2',
        'rating2',
        'description',
        'qr_code_url',  // Added
        'receipt_url'   // Added
    ];

    public function skilledWorker()
    {
        return $this->belongsTo(SkilledWorker::class, 'request_id', 'user_id');
    }
}