<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DoneChapter extends Model
{
    protected $table = 'done_chapters';
    protected $connection = 'mysql';
    protected $fillable = [
        'user_id',
        'class_id',
        'chapter_id'
    ];
    protected $appends = ['total_done'];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function class()
    {
        return $this->belongsTo('App\Classes', 'class_id', 'id');
    }

    public function chapter()
    {
        return $this->belongsTo('App\Chapters', 'chapter_id', 'id');
    }

    public function getTotalDoneAttribute()
    {
        return $this->where('user_id', '=', Auth()->user()->id)->where('class_id', '=', $this->class->id)->count('chapter_id');
    }
}
