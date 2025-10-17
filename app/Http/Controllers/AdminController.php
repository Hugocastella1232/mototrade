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
        $motos = Listing::orderByDesc('created_at')->paginate(10);
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

        $request->validate([
            'brand' => 'required|string|max:100',
            'model' => 'required|string|max:100',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'km' => 'nullable|integer|min:0',
            'power_hp' => 'nullable|integer|min:0',
            'displacement_cc' => 'nullable|integer|min:0',
            'fuel' => 'nullable|string|max:50',
            'condition' => 'nullable|string|max:50',
            'price_cents' => 'required|integer|min:0',
            'description' => 'nullable|string|max:2000',
        ]);

        $moto->update([
            'brand' => $request->brand,
            'model' => $request->model,
            'year' => $request->year,
            'km' => $request->km,
            'power_hp' => $request->power_hp,
            'displacement_cc' => $request->displacement_cc,
            'fuel' => $request->fuel,
            'condition' => $request->condition,
            'price_cents' => $request->price_cents,
            'description' => $request->description,
            'title' => $request->title ?? "{$request->brand} {$request->model} {$request->year}",
        ]);

        return redirect()->route('admin.motos')->with('success', 'Moto actualizada correctamente.');
    }

    public function destroyMoto($id)
    {
        Listing::findOrFail($id)->delete();
        return back()->with('success', 'Moto eliminada correctamente.');
    }

    public function approve($id)
    {
        $listing = Listing::findOrFail($id);
        $listing->status = Listing::STATUS_APPROVED;
        $listing->published_at = now();
        $listing->save();

        return redirect()->back()->with('success', 'Moto aprobada y publicada.');
    }

    public function reject($id)
    {
        $listing = Listing::findOrFail($id);
        $listing->status = Listing::STATUS_REJECTED;
        $listing->save();

        return redirect()->back()->with('error', 'Moto rechazada.');
    }

    public function usuarios()
    {
        $usuarios = User::where('is_admin', false)->paginate(10);
        return view('admin.usuarios', compact('usuarios'));
    }

    public function destroyUsuario($id)
    {
        User::where('id', $id)->where('is_admin', false)->delete();
        return back()->with('success', 'Usuario eliminado correctamente.');
    }
}