<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function motos()
    {
        $motos = Listing::orderByDesc('id')->paginate(10);
        return view('admin.listings', compact('motos'));
    }

    public function editMoto($id)
    {
        $moto = Listing::findOrFail($id);
        return view('admin.edit_moto', compact('moto'));
    }

    public function updateMoto(Request $request, $id)
    {
        $moto = Listing::findOrFail($id);

        if ($moto->status === Listing::STATUS_SOLD) {
            abort(403);
        }

        $moto->update($request->only([
            'brand',
            'model',
            'year',
            'km',
            'power_hp',
            'displacement_cc',
            'fuel',
            'listing_condition',
            'price_eur',
            'description'
        ]));

        return back();
    }

    public function destroyMoto($id)
    {
        $moto = Listing::findOrFail($id);

        if ($moto->status === Listing::STATUS_SOLD) {
            abort(403);
        }

        $moto->delete();
        return back();
    }

    public function updateStatus(Request $request, $id)
    {
        $listing = Listing::findOrFail($id);
        $from = $listing->status;
        $to = $request->status;

        $allowed = [
            'pending' => ['approved'],
            'sold_pending' => ['sold'],
        ];

        if (!isset($allowed[$from]) || !in_array($to, $allowed[$from])) {
            abort(403);
        }

        $listing->status = $to;

        if ($to === Listing::STATUS_APPROVED && !$listing->published_at) {
            $listing->published_at = now();
        }

        $listing->save();

        return back();
    }

    public function usuarios()
    {
        $usuarios = User::where('is_admin', false)->paginate(10);
        return view('admin.usuarios', compact('usuarios'));
    }

    public function destroyUsuario($id)
    {
        User::where('id', $id)->where('is_admin', false)->delete();
        return back();
    }
}