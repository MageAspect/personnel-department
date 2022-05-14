<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class CareerJournal extends Model
{
    use HasFactory;

    protected $collection = 'users_career_journal';

    protected $dates = [
        'started_at',
        'ended_at',
    ];

    protected $guarded = [];

    public $timestamps = false;

    public function department()
    {
        return $this->hasOne(Department::class, '_id', 'department_id');
    }
}
