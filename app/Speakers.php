<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Speakers extends Model
{
    use SoftDeletes;
    protected $table = 'speakers';
    protected $connection = 'mysql';
    protected $fillable = [
        'name',
        'skill',
        'signature',
        'profil_pic',
    ];

    public function class()
    {
        return $this->hasMany('App\Classes', 'speaker_id', 'id');
    }
}
