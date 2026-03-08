<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    protected $fillable = [
        'name',
        'color',
    ];
    
    public function cars(): BelongsToMany
    {
        return $this->belongsToMany(Car::class, 'car_tags', 'tag_id', 'car_id');
    }
}
