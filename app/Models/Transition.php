<?php

namespace App\Models;

use App\Models\Event;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transition extends Model
{
    use HasFactory;

    public $guarded = [];

    public function event()
    {
        return $this->morphOne(Event::class, 'eventable');
    }
}
