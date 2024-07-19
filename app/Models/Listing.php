<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Listing extends Model
{
    use HasFactory;

    // $protected $fillable = ['beds', 'baths', 'arae'];
    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeMostRecent(Builder $query): Builder
    {
        return $query->orderByDesc('created_at');
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when(
                $filters['priceFrom'] ?? null,
                fn($query, $value) => $query->where('price', '>=', $value)
            )
            ->when(
                $filters['priceTo'] ?? null,
                fn($query, $value) => $query->where('price', '<=', $value)
            )
            ->when(
                $filters['beds'] ?? null,
                fn($query, $value) => $query->where('beds', (int) $value < 6 ? '=' : '>=', $value)
            )
            ->when(
                $filters['baths'] ?? null,
                fn($query, $value) => $query->where('baths', (int) $value < 6 ? '=' : '>=', $value)
            )
            ->when(
                $filters['areaFrom'] ?? null,
                fn($query, $value) => $query->where('area', '>=', $value)
            )
            ->when(
                $filters['areaTo'] ?? null,
                fn($query, $value) => $query->where('area', '<=', $value)
            );
    }
}
