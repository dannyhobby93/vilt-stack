<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class RealtorListingController extends Controller
{
    public function __construct()
    {
        // TODO: Fix this for version 11
        // Automatically applies the ListingPolicy to this controller's actions
        // $this->authorizeResource(Listing::class, 'listing');
    }
    public function index(Request $request)
    {
        $filters = [
            'deleted' => $request->boolean('deleted'),
            ...$request->only(['by', 'order'])
        ];

        // 1/0 true/false
        // $request->boolean('deleted'); 
        return inertia('Realtor/Index', [
            'filters' => $filters,
            'listings' => Auth::user()
                ->listings()
                ->filter($filters)
                ->withCount('images')
                ->withCount('offers')
                ->paginate(6)
                ->withQueryString()
        ]);
    }

    public function show(Listing $listing)
    {
        Gate::authorize('view', $listing);

        return inertia(
            'Realtor/Show',
            [
                'listing' => $listing->load('offers', 'offers.bidder')
            ]
        );
    }

    public function create()
    {
        return inertia('Realtor/Create');
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
            ->route('realtor.listing.index')
            ->with('success', 'Listing was created!');
    }

    public function edit(Listing $listing)
    {
        Gate::authorize('update', $listing);

        return inertia(
            'Realtor/Edit',
            ['listing' => $listing]
        );
    }

    public function update(Request $request, Listing $listing)
    {
        Gate::authorize('update', $listing);

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
            ->route('realtor.listing.index')
            ->with('success', 'Listing was updated!');
    }

    public function destroy(Listing $listing)
    {
        Gate::authorize('delete', $listing);
        // $listing->forceDelete();
        // $listing->delete();
        $listing->deleteOrFail();

        return redirect()
            ->back()
            ->with('success', 'Listing was deleted!');
    }

    public function restore(Listing $listing)
    {
        Gate::authorize('restore', $listing);

        $listing->restore();

        return redirect()
            ->back()
            ->with('success', 'Listing was restored!');
    }
}
