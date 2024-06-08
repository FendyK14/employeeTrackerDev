<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $primaryKey = 'activityId';

    protected $fillable = [
        'activityName', 'startDate', 'endDate', 'projectId', 'status', 'employeeId', 'priority', 'description', 'subActivityId'
    ];

    public function employees()
    {
        return $this->belongsTo(Employee::class, 'employeeId', 'employeeId');
    }

    public function projects()
    {
        return $this->belongsTo(Project::class, 'projectId', 'projectId');
    }

    public function sub_activities()
    {
        return $this->belongsTo(Sub_Activity::class, 'subActivityId', 'subActivityId');
    }

    public function comments()
    {
        return $this->belongsToMany(Comment::class, 'detail_activity_comments', 'commentId', 'activityId');
    }
}
