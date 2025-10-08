@php
    $active = request()->path();
@endphp

<aside class="w-64 bg-gradient-to-b from-blue-800 via-white-900 to-blue text-black shadow-lg min-h-screen">
    <div class="p-4 font-bold text-white text-xl border-b border-cyan-600">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" style="margin-left: 50px;" width="100">
    </div>

    <ul class="py-4 px-2 space-y-1">
        <li>
            <a href="/dashboard/admin-unitkerja"
                class="flex items-center px-4 py-2 rounded transition 
                {{ request()->is('dashboard/admin-unitkerja') ? 'bg-cyan-200 font-semibold shadow-md' : 'hover:bg-cyan-100' }}">
                🏠 Dashboard
            </a>
        </li>

        <li>
            <a href="{{ route('admin-unitkerja.peserta-magang') }}"
                class="flex items-center px-4 py-2 rounded transition 
                {{ request()->is('admin-unitkerja/peserta-magang*') ? 'bg-cyan-200 font-semibold shadow-md' : 'hover:bg-cyan-100' }}">
                👨‍💼 Karyawan Magang
            </a>

        </li>
        <li>
    <a href="{{ route('admin-unitkerja.permohonan-periode') }}"
        class="flex items-center px-4 py-2 rounded transition 
        {{ str_contains($active, 'permohonan-periode') && !str_contains($active, 'lulus') ? 'bg-cyan-200 font-semibold shadow-md' : 'hover:bg-cyan-100' }}">
        👨‍💼 Permohonan Periode Peserta Magang
    </a>
</li>

        <li>
            <a href="{{ route('admin-unitkerja.peserta-lulus.index') }}"
                class="flex items-center px-4 py-2 rounded transition 
                {{ str_contains($active, 'lulus') ? 'bg-cyan-200 font-semibold shadow-md' : 'hover:bg-cyan-100' }}">
                🎓 Karyawan Lulus
            </a>
        </li>
    </ul>
</aside>
