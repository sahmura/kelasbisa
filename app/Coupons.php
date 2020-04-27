<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupons extends Model
{
    protected $connection = 'mysql';
    protected $table = 'coupons';
    protected $fillable = [
        'class_id',
        'coupon',
        'discount'
    ];

    public function class()
    {
        return $this->belongsTo('App\Classes', 'class_id', 'id');
    }
}
