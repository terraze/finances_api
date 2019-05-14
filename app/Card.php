<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    public function effects()
    {
        return $this->hasMany('Effect');
    }

    public function faction()
    {
        return $this->belongsTo('Faction');
    }
}
