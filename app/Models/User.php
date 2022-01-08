<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
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

    public function isAdministrator(): bool
    {
        return (bool) $this->is_admin;
    }

    public function canViewSalary(User $user): ?int
    {
        return $this->can('viewWorkFields', $user);
    }

    function scopeWithName($query, $name)
    {
        $names = explode(" ", $name);

        $names[0] = !empty($names[0]) ? "%$names[0]%" : '%%';
        $names[1] = !empty($names[1]) ? "%$names[1]%" : '%%';

        return User::where(function ($query) use ($names) {
            $query->orWhere(function ($query) use ($names) {
                $query->where('name', 'ilike', $names[0]);
                $query->where('last_name', 'ilike', $names[1]);
            });
            $query->orWhere(function ($query) use ($names) {
                $query->where('last_name', 'ilike', $names[0]);
                $query->where('name', 'ilike', $names[1]);
            });
        });
    }
}
