<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $primaryKey = 'projectId';

    protected $fillable = [
        'projectName', 'startDate', 'endDate', 'groupId', 'status'
    ];

    public function activities(){
        return $this->hasMany(Activity::class, 'projectId', 'projectId');
    }

    public function groups(){
        return $this->hasOne(Group::class, 'groupId', 'groupId');
    }
}
