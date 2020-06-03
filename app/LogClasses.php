<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LogClasses extends Model
{
    use SoftDeletes;
    protected $connection = 'mysql';
    protected $table = 'log_classes';
    protected $fillable = [
        'transaction_id',
        'user_id',
        'class_id',
        'transaction_code'
    ];
    protected $appends = ['total_chapter'];

    public function transaction()
    {
        return $this->belongsTo('App\Transactions', 'transaction_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function class()
    {
        return $this->belongsTo('App\Classes', 'class_id', 'id');
    }

    public function getTotalChapterAttribute()
    {
        return $this->class->chapters->count();
    }
}
