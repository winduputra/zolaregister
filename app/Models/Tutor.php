<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tutor extends Model
{
    protected $fillable = ['name'];

    public function registers()
    {
        return $this->hasMany(Register::class);
    }
}
