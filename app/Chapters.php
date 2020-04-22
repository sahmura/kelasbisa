<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chapters extends Model
{
    use SoftDeletes;
    protected $connection = 'mysql';
    protected $table = 'chapters';
    protected $fillable = [
        'class_id',
        'title',
        'description',
        'video_url',
        'sub_chapter_id'
    ];

    public function class()
    {
        return $this->belongsTo('App\Classes', 'class_id', 'id');
    }

    public function subchapter()
    {
        return $this->hasMany('App\SubChapters', 'sub_chapter_id', 'id');
    }
}
