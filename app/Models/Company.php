<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class, 'company_id');
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class, 'company_id');
    }
}
