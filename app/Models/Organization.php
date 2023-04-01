<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organization extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone',
        'desc',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'org_id', 'id');
    }

    public function actuators(): HasMany
    {
        return $this->hasMany(Actuator::class, 'org_id', 'id');
    }

    public function nodes(): HasMany
    {
        return $this->hasMany(nodes::class, 'org_id', 'id');
    }
}
