<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    public function detail_groups(){
        return $this->hasMany(Detail_Group::class);
    }

    public function projects(){
        return $this->hasOne(Project::class);
    }
}
