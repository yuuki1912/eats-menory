<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Eats extends Model
{
    protected $fillable = ['title', 'body', 'create_at'];

    public function comments() {
        return $this->hasMany('App\Comment');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function users() {
        return $this->belongsToMany('App\User')->withTimestamps();
    }
}
