<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_Group extends Model
{
    use HasFactory;

    public function groups(){
        return $this->belongsTo(Group::class);
    }

    public function employees(){
        return $this->belongsTo(Employee::class);
    }
}
