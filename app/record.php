<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class record extends Model
{
    public $timestamps = false;
    
    // Many-to-One relationship
    public function faculties()
    {
        return $this->belongsTo('App\file', 'file_id', 'id');
    }
}
