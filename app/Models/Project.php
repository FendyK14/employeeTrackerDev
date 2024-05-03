<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    public function activities(){
        return $this->hasMany(Activity::class);
    }

    public function groups(){
        return $this->hasOne(Group::class);
    }
}
