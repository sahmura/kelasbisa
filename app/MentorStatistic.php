<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MentorStatistic extends Model
{
    protected $table = 'mentor_statistics';
    protected $connection = 'mysql';
    protected $fillable = [
        'user_id',
        'speaker_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function speaker()
    {
        return $this->belongsTo('App\Speakers', 'speaker_id', 'id');
    }
}
