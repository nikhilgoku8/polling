<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PollingVote extends Model
{
    protected $table = 'polling_votes';

    protected $fillable = [
        'polling_id',
        'user_id',
        'voted_for_id'
    ];

    public function polling()
    {
        return $this->belongsTo(Polling::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // candidate (the one receiving the vote)
    public function candidate()
    {
        return $this->belongsTo(User::class, 'voted_for_id');
    }
}
