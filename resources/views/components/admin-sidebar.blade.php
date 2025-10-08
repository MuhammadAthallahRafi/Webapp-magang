@php
    $active = request()->path();
@endphp

<aside class="w-64 bg-gradient-to-b from-black-800 via-white-900 to-blue text-black shadow-lg min-h-screen">


    <div class="p-4 font-bold text-white text-xl border-b border-cyan-600">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" style="margin-left: 50px;" width="100">

    </div>
    <ul class="py-4 px-2 space-y-1">

        <li>
            <a href="/dashboard/admin"
                class="flex items-center px-4 py-2 rounded transition 
                {{ $active == 'dashboard/admin' ? 'bg-cyan-200 font-semibold shadow-md' : 'hover:bg-cyan-100' }}">
                🏠 Dashboard
            </a>
        </li>

        <li>
             <a href="{{ route('admin.akun-user.index') }}"
                class="flex items-center px-4 py-2 rounded transition 
                {{ str_contains($active, 'akun-user') ? 'bg-cyan-200 font-semibold shadow-md' : 'hover:bg-cyan-100' }}">
                👥Akun User
            </a>
        </li>
        
        <li>
            <a href="/admin/pelamar"
                class="flex items-center px-4 py-2 rounded transition 
                {{ str_contains($active, 'pelamar') ? 'bg-cyan-200 font-semibold shadow-md' : 'hover:bg-cyan-100' }}">
                👨‍🎓 Pelamar Magang
            </a>
        </li>

         <li>
            <a href="/admin/pelamarditolak"
                class="flex items-center px-4 py-2 rounded transition 
                {{ str_contains($active, 'pelamarditolak') ? 'bg-cyan-200 font-semibold shadow-md' : 'hover:bg-cyan-100' }}">
                👨Pelamar Terlolak
            </a>
        </li>

        <li>
            <a href="/admin/peserta-magang"
                class="flex items-center px-4 py-2 rounded transition 
                {{ str_contains($active, 'magang') && !str_contains($active, 'lulus') ? 'bg-cyan-200 font-semibold shadow-md' : 'hover:bg-cyan-100' }}">
                👨‍💼 Peserta Magang
            </a>
        </li>

         <li>
            <a href="/admin/permohonan-periode"
                class="flex items-center px-4 py-2 rounded transition 
                {{ str_contains($active, 'permohonan-periode') && !str_contains($active, 'lulus') ? 'bg-cyan-200 font-semibold shadow-md' : 'hover:bg-cyan-100' }}">
                👨‍💼 permohonan-periode Peserta Magang
            </a>
        </li>

        <li>
            <a href="{{ route('admin.peserta-lulus.index') }}"
                class="flex items-center px-4 py-2 rounded transition 
                {{ str_contains($active, 'lulus') ? 'bg-cyan-200 font-semibold shadow-md' : 'hover:bg-cyan-100' }}">
                🎓 Karyawan Lulus
            </a>

        </li>
    </ul>
</aside>
