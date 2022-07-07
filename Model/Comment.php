<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['body'];

    public function eats() {
        return $this->belongsTo('App\Eats');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }
}
