<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Validations extends Model
{
    protected $connection = 'mysql';
    protected $tabe = 'validations';
    protected $fillable = [
        'user_id', 'tokens', 'status', 'type'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }
}
