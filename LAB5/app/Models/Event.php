<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Event extends Model
{
    protected $fillable = [
        'name',
        'description',
        'type',
        'organizer_id',
        'date',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Organizer::class);
    }
}
