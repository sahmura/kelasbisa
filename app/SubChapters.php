<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubChapters extends Model
{
    use SoftDeletes;
    protected $connection = 'mysql';
    protected $table = 'sub_chapters';
    protected $fillable = [
        'class_id',
        'name',
        'description'
    ];

    public function chapter()
    {
        return $this->belongsTo('App\Chapters', 'sub_chapter_id', 'id');
    }

    public function class()
    {
        return $this->belongsTo('App\Classes', 'class_id', 'id');
    }
}
