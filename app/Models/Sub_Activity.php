<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sub_Activity extends Model
{
    use HasFactory;

    public function activities(){
        return $this->hasMany(Activity::class);
    }
}
