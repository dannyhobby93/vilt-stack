<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Listing;
use App\Notifications\OfferMade;
use Illuminate\Http\Request;

class ListingOfferController extends Controller
{
    public function store(Listing $listing, Request $request)
    {
        $offer = $listing->offers()->save(
            Offer::make(
                $request->validate([
                    'amount' => 'required|integer|min:1|max:20000000'
                ])
            )->bidder()->associate($request->user())
        );

        $listing->user->notify(
            new OfferMade($offer)
        );

        return back()->with('success', 'Offer was made!');
    }
}
