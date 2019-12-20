<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $dates = ['expiry_date'];
    protected $guarded = [];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
