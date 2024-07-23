<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\ListingImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RealtorListingImageController extends Controller
{
    public function create(Listing $listing)
    {
        $listing->load(['images']);

        return inertia(
            'Realtor/ListingImage/Create',
            ['listing' => $listing]
        );
    }
    public function store(Listing $listing, Request $request)
    {
        if ($request->hasFile('images')) {
            $request->validate([
                'images.*' => 'mimes:jpg,jpeg|max:5000'
            ], [
                'images.*.mimes' => 'The file should be in one of the formats: jpg, jpeg'
            ]);

            foreach ($request->file('images') as $file) {
                $path = $file->store('images', 'public');

                $listing->images()->save(new ListingImage([
                    'filename' => $path
                ]));
            }
            return back()->with('success', 'Image(s) uploaded!');
        } else {
            abort(415);
        }
    }

    public function destroy($listing, ListingImage $image)
    {
        Storage::disk('public')->delete($image->filename);

        $image->delete();

        return back()->with('success', 'Image was deleted!');
    }
}
