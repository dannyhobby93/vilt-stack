<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Listing extends Model
{
    use HasFactory, SoftDeletes;

    // $protected $fillable = ['beds', 'baths', 'arae'];
    protected $guarded = [];

    protected $sortable = [
        'price',
        'created_at'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ListingImage::class);
    }

    public function offers(): HasMany
    {
        return $this->hasMany(Offer::class, 'listing_id');
    }

    public function scopeMostRecent(Builder $query): Builder
    {
        return $query->orderByDesc('created_at');
    }

    public function scopeWithoutSold(Builder $query): Builder
    {
        // return $query->doesntHave('offers')
        //     ->orWhereHas(
        //         'offers',
        //         fn(Builder $query) => $query
        //             ->whereNull('accepted_at')
        //             ->whereNull('rejected_at')
        //     );
        return $query->whereNull('sold_at');
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
            )
            ->when(
                $filters['deleted'] ?? null,
                fn($query, $value) => $query->withTrashed()
            )
            ->when(
                $filters['by'] ?? false,
                fn($query, $value) =>
                !in_array($value, $this->sortable) ?
                $query :
                $query->orderBy($value, $filters['order'] ?? 'desc')
            );
    }
}
