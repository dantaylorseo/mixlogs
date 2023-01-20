<?php

namespace App\Models;

use App\Models\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    public $guarded = [];

    public function eventable()
    {
        return $this->morphTo();
    }

    public function log()
    {
        return $this->belongsTo(Log::class);
    }
}
