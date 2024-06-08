<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $primaryKey = 'companyId';
    protected $table = 'companies';
    protected $fillable = [
        'companyName',
        'companyEmail',
        'companyPhone',
        'companyAddress',
    ];

    // connect main database
    public function getConnectionName()
    {
        return env('DB_CONNECTION', config('database.default'));
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

}
