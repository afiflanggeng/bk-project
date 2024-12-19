@extends('pasien.dashboard_pasien')

@section('content')
<div class="container mx-auto mt-10 px-4">
    <h1 class="text-3xl font-semibold text-center text-blue-600 mb-8">Jadwal Anda</h1>

    @if($daftarPolis->isEmpty())
        <div class="bg-yellow-100 text-yellow-700 p-4 rounded-md shadow-md text-center">
            Anda belum memiliki jadwal yang terdaftar.
        </div>
    @else
        <div class="overflow-x-auto shadow-md rounded-lg">
            <table class="min-w-full table-auto bg-white rounded-lg">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="px-4 py-2 text-left">No.</th>
                        <th class="px-4 py-2 text-left">Jadwal</th>
                        <th class="px-4 py-2 text-left">No. Antrian</th>
                        <th class="px-4 py-2 text-left">Keluhan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($daftarPolis as $index => $daftar)
                    <tr class="hover:bg-gray-100">
                        <td class="px-4 py-2">{{ $index + 1 }}</td>
                        <td class="px-4 py-2">{{ $daftar->jadwalPeriksa->hari }} {{ $daftar->jadwalPeriksa->jam_mulai }} - {{ $daftar->jadwalPeriksa->jam_selesai }}</td>
                        <td class="px-4 py-2 text-center">{{ $daftar->no_antrian }}</td>
                        <td class="px-4 py-2">{{ $daftar->keluhan }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
