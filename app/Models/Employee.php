<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Employee extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'employees';
    protected $primaryKey = 'employeeId';

    protected $fillable = [
        'employeeName', 'DOB', 'employeeEmail', 'noTelp', 'password', 'gender', 'employeeAddress', 'companyId', 'positionId', 'email_verified_at'
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function companies()
    {
        return $this->belongsTo(Company::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'employeeId', 'employeeId');
    }

    public function performances()
    {
        return $this->hasMany(Performance::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function positions()
    {
        return $this->belongsTo(Position::class, 'positionId', 'positionId');
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'detail_employee_groups', 'employeeId', 'groupId')->withPivot('isLeader');
    }

    public function leader()
    {
        return $this->groups()->wherePivot('isLeader', true)->first();
    }

    public function comments(){
        return $this->hasMany(Comment::class, 'employeeId', 'employeeId');
    }
}
