<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PollingCandidate extends Model
{
    protected $table = 'polling_candidates';

    protected $fillable = [
        'polling_id',
        'user_id'
    ];

    public function polling()
    {
        return $this->belongsTo(Polling::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
