<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faction extends Model
{
    protected $fillable = ['name', 'color', 'key'];

    protected $dates = ['deleted_at'];

    public function cards()
    {
        return $this->hasMany('Card');
    }
}
