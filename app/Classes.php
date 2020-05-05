<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classes extends Model
{
    use SoftDeletes;
    protected $connection = 'mysql';
    protected $table = 'classes';
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'cover',
        'terms',
        'type',
        'prices',
        'speakers',
        'modul_url',
        'is_draft'
    ];

    public function category()
    {
        return $this->belongsTo('App\Categories', 'category_id', 'id');
    }

    public function chapters()
    {
        return $this->hasMany('App\Chapters', 'class_id', 'id');
    }

    public function coupon()
    {
        return $this->hasMany('App\Coupons', 'class_id', 'id');
    }
}
