<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    public function companies(){
        return $this->belongsTo(Company::class);
    }

    public function attendances(){
        return $this->hasMany(Attendance::class);
    }

    public function performances(){
        return $this->hasMany(Performance::class);
    }

    public function activities(){
        return $this->hasMany(Activity::class);
    }

    public function positions(){
        return $this->belongsTo(Position::class);
    }

    public function detail_groups(){
        return $this->hasMany(Detail_Group::class);
    }

    public function detail_comments(){
        return $this->hasMany(Detail_Comment::class);
    }
}
