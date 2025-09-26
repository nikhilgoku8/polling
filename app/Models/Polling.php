<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Polling extends Model
{
    protected $table = 'pollings';

    protected $fillable = [
        'title',
        'poll_type',
        'winner_type',
        'status'
    ];

    public function candidates()
    {
        return $this->belongsToMany(User::class, 'polling_candidates', 'polling_id', 'user_id');
    }

    public function votes()
    {
        return $this->hasMany(PollingVote::class);
    }
}
