<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareerJournal extends Model
{
    use HasFactory;

    protected $table = 'users_career_journal';

    protected $dates = [
        'started_at',
        'ended_at',
    ];

    protected $guarded = [];

    public $timestamps = false;

    public function department()
    {
        return $this->hasOne(Department::class, 'id', 'department_id');
    }
}
