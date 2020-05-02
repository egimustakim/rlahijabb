<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Materials extends Model
{
    protected $fillable = ['name'];

    public function setNameAttribute($value) {
        $this->setNameAttribute['name'] = strtoupper($value);
    }
}
