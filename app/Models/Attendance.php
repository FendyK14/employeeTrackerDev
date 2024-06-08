<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $primaryKey = 'attendanceId';

    protected $fillable = [
        'employeeId',
        'clockIn',
        'clockOut',
        'workType',
        'status',
        'image',
    ];

    public function employees(){
        return $this->belongsTo(Employee::class, 'employeeId', 'employeeId');
    }
}
