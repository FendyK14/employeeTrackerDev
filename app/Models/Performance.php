<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Performance extends Model
{
    use HasFactory;

    protected $primaryKey = 'performanceId';

    protected $fillable = [
        'employeeId',
        'description',
        'attendanceScore',
        'communicationScore',
        'responsibilityScore',
        'qualityWorkScore',
        'collaborationScore',
        'evaluationDate',
        'notes',
        'status',
        'employeeId',
    ];

    public function employees(){
        return $this->belongsTo(Employee::class, 'employeeId');
    }
}
