<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agendas extends Model
{
    use SoftDeletes;
    protected $table = 'agendas';
    protected $connection = 'mysql';
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'target',
        'result'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
