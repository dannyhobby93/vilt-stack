<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

// class ListingController extends Controller
class ListingController extends \Illuminate\Routing\Controller
{
    use AuthorizesRequests;
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
        $this->authorizeResource(Listing::class, 'listing');
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
                    ->paginate(6)
                    ->withQueryString()
            ]
        );
    }

    public function create()
    {
        return inertia('Listing/Create');
    }

    public function store(Request $request)
    {
        $request->user()->listings()->create(
            $request->validate([
                'beds' => 'required|integer|min:0|max:20',
                'baths' => 'required|integer|min:0|max:20',
                'area' => 'required|integer|min:15|max:20000',
                'city' => 'required',
                'code' => 'required',
                'street' => 'required',
                'street_number' => 'required|integer|min:1|max:10000',
                'price' => 'required|integer|min:1|max:20000000',
            ])
        );

        return redirect()
            ->route('listing.index')
            ->with('success', 'Listing was created!');
    }

    // public function show(string $id)
    public function show(Listing $listing)
    {
        // if (Auth::user()->cannot('view', $listing)) {
        //     abort(403);
        // }
        // Gate::authorize('view', $listing);

        return inertia(
            'Listing/Show',
            ['listing' => $listing]
        );
    }

    public function edit(Listing $listing)
    {
        return inertia(
            'Listing/Edit',
            ['listing' => $listing]
        );
    }

    public function update(Request $request, Listing $listing)
    {
        $listing->update(
            $request->validate([
                'beds' => 'required|integer|min:0|max:20',
                'baths' => 'required|integer|min:0|max:20',
                'area' => 'required|integer|min:15|max:20000',
                'city' => 'required',
                'code' => 'required',
                'street' => 'required',
                'street_number' => 'required|integer|min:1|max:10000',
                'price' => 'required|integer|min:1|max:20000000',
            ])
        );

        return redirect()
            ->route('listing.index')
            ->with('success', 'Listing was updated!');
    }

    public function destroy(Listing $listing)
    {
        $listing->delete();

        return redirect()
            ->back()
            ->with('success', 'Listing was deleted!');
    }
}
