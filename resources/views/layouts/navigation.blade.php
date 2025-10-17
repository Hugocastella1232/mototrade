<nav class="bg-red-600 text-white">
  <div class="max-w-7xl mx-auto px-4 h-20 flex items-center">
    {{-- Izquierda: logo + marca --}}
    <a href="{{ route('home') }}" class="flex items-center gap-4">
      <img src="{{ asset('logo.png') }}" class="h-12 w-auto" alt="Moto Trade">
      <span class="text-2xl font-semibold">Moto Trade</span>
    </a>

    {{-- Centro: navegación --}}
    <div class="flex-1 flex justify-center items-center gap-6">
      <a href="{{ route('catalogo') }}" class="px-3 py-2 hover:underline">Catálogo</a>

      {{-- Mostrar enlace del panel solo a administradores --}}
      @auth
        @if(auth()->user()->is_admin)
          <a href="{{ route('admin.index') }}" class="px-3 py-2 font-semibold hover:underline text-yellow-200">
            Panel administrador
          </a>
        @endif
      @endauth
    </div>

    {{-- Derecha: cuenta --}}
    <div class="flex items-center gap-4">
      @auth
        <a href="{{ route('profile.edit') }}" class="hover:underline">Mi cuenta</a>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="hover:underline">Cerrar sesión</button>
        </form>
      @else
        <a href="{{ route('login') }}" class="hover:underline">Entrar</a>
        <a href="{{ route('register') }}" class="hover:underline">Registrarse</a>
      @endauth
    </div>
  </div>
</nav>