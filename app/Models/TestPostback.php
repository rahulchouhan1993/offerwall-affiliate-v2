<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestPostback extends Model
{
    public function apps(){
        return $this->hasOne(App::class,'id','app_id');
    }
}
