<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Register extends Model
{
    protected $fillable = [
        'user_id',
        'tutor_id',
        'class_code_id',
        'register_date',
        'start_time',
        'end_time',
        'student_count',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'register_date' => 'date',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tutor()
    {
        return $this->belongsTo(Tutor::class);
    }

    public function classCode()
    {
        return $this->belongsTo(ClassCode::class);
    }

    /**
     * Get formatted time range "HH:MM - HH:MM"
     */
    public function getTimeRangeAttribute(): string
    {
        $start = Carbon::parse($this->start_time)->format('H:i');
        $end = Carbon::parse($this->end_time)->format('H:i');
        return "{$start} - {$end}";
    }
}
