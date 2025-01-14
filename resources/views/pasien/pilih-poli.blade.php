@extends('pasien.dashboard_pasien')  
  
@section('content')  
    <div class="container mx-auto px-4 mt-10">  
        <h1 class="text-3xl font-semibold text-center text-blue-600 mb-8">Pilih Poli</h1>  
  
        @if (session('error'))  
            <div class="alert alert-danger">  
                {{ session('error') }}  
            </div>  
        @endif  
  
        @if (session('success'))  
            <div class="alert alert-success">  
                {{ session('success') }}  
            </div>  
        @endif  
  
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">  
            @foreach ($polis as $poli)  
                <div class="bg-white shadow-md rounded px-4 py-6 text-center">  
                    <h5 class="text-xl font-bold mb-2">{{ $poli->nama_poli }}</h5>  
                    <p class="text-gray-700">{{ $poli->keterangan }}</p>  
                    <a href="{{ route('pasien.pilih-dokter', ['poli_id' => $poli->id]) }}"  
                       class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Pilih</a>  
                </div>  
            @endforeach  
        </div>  
    </div>  
@endsection  