<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pasien</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-blue-600 text-white flex flex-col">
            <div class="p-6">
                <h2 class="text-2xl font-bold">Poliklinik</h2>
            </div>
            <nav class="flex-1">
                <ul>
                    <li class="px-6 py-3 hover:bg-blue-700">
                        <a href="{{ route('pasien.pilih-poli') }}" class="block">Pilih Poli</a>
                    </li>
                    <li class="px-6 py-3 hover:bg-blue-700">
                        <a href="{{ route('pasien.jadwal') }}" class="block">Jadwal</a>
                    </li>
                </ul>
            </nav>
            <form method="POST" action="{{ route('logoutpasien') }}" class="p-6">
                @csrf
                <button type="submit" class="w-full bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600">Logout</button>
            </form>
        </aside>

        <!-- Content -->
        <main class="flex-1 bg-gray-100 p-8">
            <div class="bg-white p-6 rounded-lg shadow-md">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
