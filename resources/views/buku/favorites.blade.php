<x-app-layout>
    @extends('layouts.layout')

    @section('title', 'Koleksi Buku')

    @section('content')
        @if(Session::has('success'))
            <div class="alert alert-success">{{Session::get('success')}}</div>
        @endif
        <div class="py-5 text-center">
            <h2><b>FAVORIT</b></h2>
        </div>

        <div class="table-responsive">
            <table class="table table-stripped table-hover">
                <thead>
                    <tr>
                        <th>Judul Buku</th>
                        <th>Penulis</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($favoriteBooks as $buku)
                        <tr>
                            <td>{{ $buku->judul }}</td>
                            <td>{{ $buku->penulis }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endsection
</x-app-layout>