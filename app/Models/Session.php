<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{ 
    use HasFactory;

    public $incrementing = false;
    protected $primaryKey = 'sessionid';
    public $timestamps = false;

    protected $guarded = [];

    protected $dates = ['timestamp'];

    public function logs() {
        return $this->hasMany(Log::class, 'sessionid', 'sessionid');
    }

}
