<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;
 
    public $incrementing = false;
    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'data' => 'object',
        'events' => 'object',
        'response' => 'object',
        'request' => 'object',
    ];

    protected $dates = ['timestamp'];

    public function application() {
        return $this->belongsTo(Application::class);
    }
}
