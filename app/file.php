<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class file extends Model
{
    public $timestamps = false;
    
    //one-to-many relationship
    public function record()
    {
        
        return $this->hasMany('App\record', 'record_id', 'id');
    }
    
}
