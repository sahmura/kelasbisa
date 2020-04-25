<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogRoll extends Model
{
    protected $connection = 'mysql';
    protected $table = 'log_roll';
    protected $fillable = [
        'user_id',
        'class_id',
        'chapter_id',
        'updated_at'
    ];

    public function class()
    {
        return $this->belongsTo('App\Classes', 'class_id', 'id');
    }

    public function chapter()
    {
        return $this->belongsTo('App\Chapters', 'chapter_id', 'id');
    }
}
