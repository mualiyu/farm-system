<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Node extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'org_id',
        'actuator_id',
        'name',
        'num',
    ];

    public function org(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'org_id');
    }

    public function actuator(): BelongsTo
    {
        return $this->belongsTo(Actuator::class, 'actuator_id');
    }
    
    public function details(): HasMany
    {
        return $this->hasMany(SensorDetail::class, 'node_id', 'id');
    }
}
