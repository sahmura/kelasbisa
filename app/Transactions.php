<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transactions extends Model
{
    use SoftDeletes;
    protected $connection = 'mysql';
    protected $table = 'transactions';
    protected $fillable = [
        'user_id',
        'class_id',
        'transaction_code',
        'status',
        'total_prices'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function class()
    {
        return $this->belongsTo('App\Classes', 'class_id', 'id');
    }
}
