<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    protected $fillable = [
        'fname',
        'mname',
        'lname',
        'email',
        'gender',
        'password'
    ];

    public function votesCast()
    {
        return $this->hasMany(PollingVote::class, 'user_id');
    }

    public function votesReceived()
    {
        return $this->hasMany(PollingVote::class, 'voted_for_id');
    }

    public function pollingsAsCandidate()
    {
        return $this->belongsToMany(Polling::class, 'polling_candidates', 'user_id', 'polling_id');
    }
}
