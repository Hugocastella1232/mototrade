<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listing;
use Illuminate\Support\Str;

class ListingController extends Controller
{
    public function create()
    {
        return view('listings.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'km' => 'required|integer|min:0',
            'power_hp' => 'nullable|integer|min:0',
            'displacement_cc' => 'nullable|integer|min:0',
            'fuel' => 'nullable|string|max:100',
            'condition' => 'nullable|string|max:50',
            'price_cents' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $path = $request->hasFile('image')
            ? $request->file('image')->store('motos', 'public')
            : null;

        $base = Str::slug($request->title);
        $slug = $base;
        $i = 1;
        while (Listing::where('slug', $slug)->exists()) {
            $slug = $base . '-' . $i++;
        }

        Listing::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'slug' => $slug,
            'brand' => $request->brand,
            'model' => $request->model,
            'year' => $request->year,
            'km' => $request->km,
            'power_hp' => $request->power_hp,
            'displacement_cc' => $request->displacement_cc,
            'fuel' => $request->fuel,
            'condition' => $request->condition,
            'price_cents' => $request->price_cents,
            'status' => 0,
            'location' => $request->location,
            'description' => $request->description,
            'image' => $path,
            'published_at' => null,
        ]);

        return redirect()->route('catalogo')->with('success', 'Moto publicada con éxito. Está pendiente de revisión por un administrador.');
    }
}