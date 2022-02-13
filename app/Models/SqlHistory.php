<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SqlHistory extends Model
{
    use HasFactory;

    protected $table = 'sql_query_history';
}
