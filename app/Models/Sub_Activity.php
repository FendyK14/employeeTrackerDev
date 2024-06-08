<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sub_Activity extends Model
{
    use HasFactory;

    protected $table = 'sub_activities';
    protected $primaryKey = 'subActivityId';

    protected $fillable = [
        'subActivityName',
    ];

    public function activities()
    {
        return $this->hasMany(Activity::class, 'subActivityId', 'subActivityId');
    }
}
