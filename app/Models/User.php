<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function departments()
    {
        return $this->belongsToMany(Department::class, 'user_department')
            ->withPivot($this->getCreatedAtColumn());
    }

    public function headOf()
    {
        return$this->hasOne(Department::class, 'head_id');
    }

    public function isAdministrator(): bool
    {
        return (bool) $this->is_admin;
    }

    function scopeWithFind(Builder $query, string $find): Builder
    {
        $names = explode(" ", $find);

        $probablyName = !empty($names[0]) ? $names[0] : '';
        $probablyLastName = !empty($names[1]) ? $names[1] : '';

        return $query->where(function ($query) use ($probablyName, $probablyLastName) {
            $query->orWhere(function ($query) use ($probablyName, $probablyLastName) {
                $query->where('name', 'ilike', "%$probablyName%");
                $query->where('last_name', 'ilike', "%$probablyLastName%");
            });
            $query->orWhere(function ($query) use ($probablyName, $probablyLastName) {
                $query->where('last_name', 'ilike', "%$probablyName%");
                $query->where('name', 'ilike', "%$probablyLastName%");
            });
        });
    }
}
