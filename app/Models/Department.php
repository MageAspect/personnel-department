<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    public function head() {
        return $this->belongsTo(User::class);
    }

    public function members() {
        return $this->belongsToMany(User::class, 'user_department');
    }
}
