<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard Admin')</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="flex bg-gray-100 text-black">

    {{-- Sidebar --}}
    @include('components.admin-sidebar')

    {{-- Main Content --}}
    <div class="flex-1 min-h-screen">
        {{-- Navbar --}}
        <div class="bg-white shadow p-4 flex justify-between items-center">
            <h1 class="text-xl font-semibold text-blue-700">@yield('title')</h1>
            <div class="space-x-4">
                <span>Halo, {{ Auth::user()->name }}</span>
                
                <form id="formLogout" action="/logout" method="GET" class="inline">
                    <button 
                        type="button" 
                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded font-semibold shadow-md" 
                        onclick="konfirmasilogout()">
                        Logout
                    </button>
                </form>

                <script>
                function konfirmasilogout() {
                    Swal.fire({
                        title: 'Yakin?',
                        text: "Maw cabut??",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ingyahh!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('formLogout').submit();
                        }
                    });
                }
                </script>
            </div>
        </div>

        {{-- Page Content --}}
        <div class="p-6">
            @yield('content')
        </div>
    </div>

    {{-- Script Section --}}
    @yield('scripts')

</body>
</html>
