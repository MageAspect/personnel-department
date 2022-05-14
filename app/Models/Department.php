<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;



class Department extends Model
{
    use HasFactory;

    protected $collection = 'departments';

    public function head()
    {
        return $this->belongsTo(User::class);
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'user_department')
            ->withPivot($this->getCreatedAtColumn());
    }
}
