<?php

namespace App\Models;

use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'company_id'
    ];

    protected static function booted(): void
    {
        if (auth()->check()) {
            static::addGlobalScope('company7', function (Builder $query) {
                $query->whereBelongsTo(Filament::getTenant());
            });
        }
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
