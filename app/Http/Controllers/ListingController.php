<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ListingController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(
            ['priceFrom', 'priceTo', 'beds', 'baths', 'areaFrom', 'areaTo']
        );

        return inertia(
            'Listing/Index',
            [
                'filters' => $filters,
                'listings' => Listing::latest()
                    ->filter($filters)
                    ->withoutSold()
                    ->paginate(6)
                    ->withQueryString()
            ]
        );
    }

    public function show(Listing $listing)
    {
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
