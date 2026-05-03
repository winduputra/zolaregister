<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassCode extends Model
{
    protected $fillable = ['program', 'code', 'duration_minutes'];

    public function registers()
    {
        return $this->hasMany(Register::class);
    }

    /**
     * Get display label: "Program - Code"
     */
    public function getDisplayNameAttribute(): string
    {
        return "{$this->program} ({$this->code})";
    }
}
