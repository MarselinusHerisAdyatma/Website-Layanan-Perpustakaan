<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;

    protected $fillable = [
        'visitor_number',
        'name',
        'address',
        'student_id',
        'gender_id',
        'profession_id',
        'education_id',
        'visit_purpose_id',
        'location_id',
        'status_id',
        'notes',
        'visited_at',
    ];

        public function profession()
    {
        return $this->belongsTo(Profession::class);
    }
}