<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Effect extends Model
{
    public function card()
    {
        return $this->belongsTo('Card');
    }
}
