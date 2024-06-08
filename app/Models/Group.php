<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $table = 'groups';
    protected $primaryKey = 'groupId';

    protected $fillable = [
        'groupName'
    ];

    public function projects()
    {
        return $this->hasOne(Project::class, 'groupId', 'groupId');
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'detail_employee_groups', 'groupId', 'employeeId')->withPivot('isLeader');
    }

    public function leader()
    {
        return $this->employees()->wherePivot('isLeader', true)->first();
    }
}
