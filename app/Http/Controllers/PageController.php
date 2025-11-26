<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listing;
use App\Models\Lead;
use App\Models\Order;

class PageController extends Controller
{
    public function home()
    {
        $motos = Listing::where('status', 'published')
            ->latest('published_at')
            ->get();

        return view('home', compact('motos'));
    }

    public function catalogo(Request $request)
    {
        $query = Listing::where('status', 'published');

        if ($request->brand) {
            $query->where('brand', 'like', "%{$request->brand}%");
        }
        if ($request->model) {
            $query->where('model', 'like', "%{$request->model}%");
        }
        if ($request->year) {
            $query->where('year', $request->year);
        }
        if ($request->km_max) {
            $query->where('km', '<=', (int)$request->km_max);
        }
        if ($request->price_min) {
            $query->where('price_eur', '>=', (int)$request->price_min);
        }
        if ($request->price_max) {
            $query->where('price_eur', '<=', (int)$request->price_max);
        }

        $motos = $query->paginate(12);
        return view('catalogo', compact('motos'));
    }

    public function ficha($slug)
    {
        $moto = Listing::where('slug', $slug)->firstOrFail();
        return view('moto', compact('moto'));
    }

    public function storeLead(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required'
        ]);

        Lead::create([
            'listing_id' => $id,
            'user_id' => auth()->id(),
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message
        ]);

        return back()->with('success', 'Tu mensaje ha sido enviado.');
    }

    public function addCarrito(Request $request, $id)
    {
        $moto = Listing::findOrFail($id);
        $carrito = session()->get('carrito', []);

        if (isset($carrito[$id])) {
            $carrito[$id]['quantity']++;
        } else {
            $carrito[$id] = [
                'id' => $moto->id,
                'title' => $moto->title,
                'price_eur' => $moto->price_eur,
                'quantity' => 1
            ];
        }

        session(['carrito' => $carrito]);
        return redirect()->route('carrito')->with('success', 'Moto añadida al carrito.');
    }

    public function removeFromCart($id)
    {
        $carrito = session()->get('carrito', []);

        if (isset($carrito[$id])) {
            if ($carrito[$id]['quantity'] > 1) {
                $carrito[$id]['quantity']--;
            } else {
                unset($carrito[$id]);
            }
        }

        session()->put('carrito', $carrito);
        return redirect()->route('carrito')->with('success', 'Producto eliminado del carrito');
    }

    public function clearCart()
    {
        session()->forget('carrito');
        return redirect()->route('carrito')->with('success', 'Carrito vaciado');
    }

    public function carrito()
    {
        $carrito = session()->get('carrito', []);
        return view('carrito', compact('carrito'));
    }

    public function checkoutForm()
    {
        $carrito = session('carrito', []);
        $total = 0;

        foreach ($carrito as $item) {
            $total += $item['price_eur'] * $item['quantity'];
        }

        return view('checkout', compact('total'));
    }
}