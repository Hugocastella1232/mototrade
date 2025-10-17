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
        $motos = Listing::where('status', \App\Models\Listing::STATUS_APPROVED)
            ->latest('published_at')
            ->get();

        return view('home', compact('motos'));
    }

    public function catalogo(Request $request)
    {
        $query = Listing::where('status', \App\Models\Listing::STATUS_APPROVED);

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
            $query->where('price_cents', '>=', (int)$request->price_min * 100);
        }
        if ($request->price_max) {
            $query->where('price_cents', '<=', (int)$request->price_max * 100);
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
            'message' => 'required',
        ]);

        Lead::create([
            'listing_id' => $id,
            'user_id' => auth()->id(),
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
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
                'price_cents' => $moto->price_cents,
                'quantity' => 1,
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

    public function checkout()
    {
        $carrito = session()->get('carrito', []);

        if (empty($carrito)) {
            return redirect()->route('carrito')->with('error', 'El carrito está vacío.');
        }

        session()->forget('carrito');
        return redirect()->route('home')->with('success', 'Compra realizada con éxito (simulada).');
    }

    public function checkoutForm()
    {
        $carrito = session('carrito', []);
        $total = 0;

        foreach ($carrito as $item) {
            $total += $item['price_cents'] * $item['quantity'];
        }

        return view('checkout', compact('total'));
    }

    public function checkoutProcess(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'dni' => 'required|string|max:20',
        ]);

        $carrito = session()->get('carrito', []);
        if (empty($carrito)) {
            return redirect()->route('carrito')->with('error', 'El carrito está vacío.');
        }

        $totalCents = collect($carrito)->sum(fn($item) => (int)$item['price_cents'] * (int)$item['quantity']);

        Order::create([
            'user_id' => auth()->id(),
            'name' => $data['name'],
            'email' => $data['email'],
            'address' => $data['address'],
            'phone' => $data['phone'],
            'dni' => $data['dni'],
            'total_cents' => $totalCents,
            'items' => array_values($carrito),
        ]);

        session()->forget('carrito');
        return redirect()->route('home')->with('success', 'Compra realizada con éxito');
    }

    public function adminListings()
    {
        $motos = Listing::where('status', \App\Models\Listing::STATUS_PENDING)->get();
        return view('admin.listings', compact('motos'));
    }

    public function approveListing($id)
    {
        $moto = Listing::findOrFail($id);
        $moto->update(['status' => \App\Models\Listing::STATUS_APPROVED, 'published_at' => now()]);
        return back()->with('success', 'Moto aprobada.');
    }

    public function rejectListing($id)
    {
        $moto = Listing::findOrFail($id);
        $moto->update(['status' => \App\Models\Listing::STATUS_REJECTED]);
        return back()->with('success', 'Moto rechazada.');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'price_cents' => 'required|integer',
            'image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('motos', 'public');
        }

        Listing::create($data);
        return redirect()->route('catalogo')->with('success', 'Moto añadida con éxito');
    }

    public function dashboard()
    {
        $stats = [
            'usuarios' => \App\Models\User::count(),
            'motos' => \App\Models\Listing::count(),
            'ventas' => 0,
            'leads' => \App\Models\Lead::count(),
        ];
        return view('admin.dashboard', compact('stats'));
    }
}