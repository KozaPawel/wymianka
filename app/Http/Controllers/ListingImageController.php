<?php

namespace App\Http\Controllers;

use App\Http\Resources\ListingResource;
use App\Models\Listing;
use App\Models\ListingImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ListingImageController extends Controller
{
    public function create(Listing $listing)
    {
        $listing->load('images');

        return inertia(
            'User/ListingImage/Create',
            [
                'listing' => ListingResource::make($listing),
            ]
        );
    }

    public function store(Listing $listing, Request $request)
    {
        $numberOfImages = 0;

        $messages = [
            'images.*.mimes' => 'Zdjęcie powinno być w formacie jpg, jpeg, png',
            'images.*.max' => 'Zdjęcie nie może przekraczać 5MB',
        ];

        if ($request->hasFile('images')) {
            $request->validate([
                'images.*' => 'mimes:jpg,jpeg,png|max:5000',
            ], $messages);
            foreach ($request->file('images') as $file) {
                $path = $file->store('images', 'public');

                $listing->images()->save(new ListingImage([
                    'filename' => $path,
                ]));
                $numberOfImages++;
            }
        }

        return redirect()->back()
            ->with('success', $numberOfImages == 1 ? 'Dodano zdjęcie' : 'Dodano zdjęcia');
    }

    public function destroy($listing, ListingImage $image)
    {
        Storage::disk('public')->delete($image->filename);
        $image->delete();

        return redirect()->back()
            ->with('success', 'Usunięto zdjęcie');
    }
}
