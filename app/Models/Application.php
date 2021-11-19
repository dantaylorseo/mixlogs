<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Crypt;

class Application extends Model
{
    use HasFactory;

    protected $guarded = [];
    //protected $with = ['logs'];

    public function users() {
        return $this->belongsToMany(User::class, 'application_user', 'application_id', 'user_id');
    }

    public function logs() {
        return $this->hasMany(Log::class)->groupBy('sessionId');
    }

    public function setClientIdAttribute( $value ) {
        $this->attributes['client_id'] = Crypt::encryptString( $value );
    }

    public function getClientIdAttribute() {
        return Crypt::decryptString( $this->attributes['client_id'] );
    }

    public function setClientSecretAttribute( $value ) {
        $this->attributes['client_secret'] = Crypt::encryptString( $value );
    }

    public function getClientSecretAttribute() {
        return Crypt::decryptString( $this->attributes['client_secret'] );
    }
}
