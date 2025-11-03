@php
    $active = request()->path();
@endphp

<aside class="w-64 bg-gradient-to-b from-black-800 via-white-900 to-blue text-black shadow-lg min-h-screen">


    <div class="p-4 font-bold text-white text-xl border-b border-cyan-600">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" style="margin-left: 50px;" width="100">

    </div>
    <ul class="py-4 px-2 space-y-1">

        <li>
        <a href="{{ route('pelamar.center') }}" 
           class="block px-4 py-2 rounded-lg font-medium hover:bg-blue-700 hover:translate-x-1 transition-all duration-200
                  {{ request()->routeIs('pelamar.center') ? 'bg-blue-700' : '' }}">
            📊 Dashboard
        </a>
        </li>

        <li>
        <a href="{{ route('pelamar.data-diri') }}" 
           class="block px-4 py-2 rounded-lg font-medium hover:bg-blue-700 hover:translate-x-1 transition-all duration-200
                  {{ request()->routeIs('pelamar.data-diri') ? 'bg-blue-700' : '' }}">
           Berkas Data-diri
        </a>
        </li>

        </li>
    </ul>
</aside>
