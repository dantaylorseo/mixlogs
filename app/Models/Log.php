<?php

namespace App\Models;

use App\Models\Event;
use App\Models\Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Log extends Model
{
    use HasFactory;
 
    public $incrementing = false;
    public $keyType = 'string';

    public $timestamps = false;

    protected $guarded = [];
    protected $appends = ['log_type'];

    protected $casts = [
        'data' => 'object',
        'events' => 'object',
        'response' => 'object',
        'request' => 'object',
    ];

    protected $dates = ['timestamp'];
    protected $with = ['application'];
    
    public function application() {
        return $this->belongsTo(Application::class);
    }

    public function session() {
        return $this->belongsTo(Session::class, 'sessionid', 'sessionid');
    }

    public function events() {
        return $this->hasMany(Event::class);
    }

    public function getLogTypeAttribute() {
      if( is_array( $this->events) ) {
        if( !empty( $this->events[0]->event ) ) {
            return ucwords($this->events[0]->event);
        } else {
            return ucwords( $this->events[0]->name );
        }
      }
      return '';
    }
}
