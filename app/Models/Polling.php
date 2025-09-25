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
        return $this->hasMany(PollingCandidate::class);
    }

    public function votes()
    {
        return $this->hasMany(PollingVote::class);
    }
}
