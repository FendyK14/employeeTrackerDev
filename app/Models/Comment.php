<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $primaryKey = 'commentId';

    protected $fillable = [
        'employeeId', 'description'
    ];

    public function employees()
    {
        return $this->belongsTo(Employee::class, 'employeeId', 'employeeId');
    }

    public function activities()
    {
        return $this->belongsToMany(Activity::class, 'detail_activity_comments', 'commentId', 'activityId');
    }
}
