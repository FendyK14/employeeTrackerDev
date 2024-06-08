<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $table = 'positions';
    protected $primaryKey = 'positionId';

    protected $fillable = ['positionName'];

    public function employees()
    {
        return $this->hasMany(Employee::class, 'positionId', 'positionId');
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'company_positions', 'positionId', 'companyId');
    }
}
