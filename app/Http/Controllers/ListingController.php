<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ListingController extends Controller
{
    public function __construct()
    {
        // TODO: Fix this for version 11
        // Automatically applies the ListingPolicy to this controller's actions
        // $this->authorizeResource(Listing::class, 'listing');
    }
    public function index(Request $request)
    {
        $filters = $request->only(
            ['priceFrom', 'priceTo', 'beds', 'baths', 'areaFrom', 'areaTo']
        );

        // $query = Listing::orderByDesc('created_at')
        //     ->when(
        //         $filters['priceFrom'] ?? null,
        //         fn($query, $value) => $query->where('price', '>=', $value)
        //     )
        //     ->when(
        //         $filters['beds'] ?? null,
        //         fn($query, $value) => $query->where('beds', (int) $value < 6 ? '=' : '>=', $value)
        //     );

        // if ($filters['priceFrom'] ?? null) {
        //     $query->where('price', '>=', $filters['priceFrom']);
        // }

        return inertia(
            'Listing/Index',
            [
                'filters' => $filters,
                // 'listings' => $query
                'listings' => Listing::latest()
                    ->filter($filters)
                    ->withoutSold()
                    ->paginate(6)
                    ->withQueryString()
            ]
        );
    }

    // public function show(string $id)
    public function show(Listing $listing)
    {
        // if (Auth::user()->cannot('view', $listing)) {
        //     abort(403);
        // }
        // Laravel 11 fix
        Gate::authorize('view', $listing);

        $listing->load('images');

        $offer = !Auth::user() ? null : $listing->offers()->byMe()->first();

        return inertia(
            'Listing/Show',
            [
                'listing' => $listing,
                'offerMade' => $offer
            ]
        );
    }


}
