<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categories extends Model
{
    use SoftDeletes;
    protected $connection = 'mysql';
    protected $table = 'categories';
    protected $fillable = [
        'name',
        'description'
    ];

    public function class()
    {
        return $this->hasMany('App\Classes', 'category_id', 'id');
    }
}
