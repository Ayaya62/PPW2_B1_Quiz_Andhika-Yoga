@extends('layouts.layout')

@section('title', 'Koleksi Buku')

@section('content')
    <div class="py-5 text-center">
        <h2><b>DAFTAR BUKU</b></h2>
        <p class="lead">
            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Expedita, reprehenderit pariatur, 
            rerum odit doloribus corrupti modi fugit facere sunt corporis fugiat quod nostrum sed 
            assumenda dicta, quos voluptatibus culpa veniam. Lorem ipsum dolor sit amet consectetur 
            adipisicing elit.
        </p>
    </div>

    <div class="table-responsive">
        <table class="table table-borderless table-hover">
            <thead class="text-start">
                <tr>
                    <th>No.</th>
                    <th>Gambar Sampul</th>
                    <th>Judul Buku</th>
                    <th>Penulis</th>
                    <th>Harga</th>
                    <th>Tanggal Terbit</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data_buku as $buku)
                    <tr>
                        <td>{{ ++$no }}</td>
                        <td>
                            @if($buku->filepath)
                                <div class="relative h-10 w-10">
                                    <img class="h-full w-full object-cover object-center rounded-2" src="{{ asset($buku->filepath) }}" alt=""/>
                                </div>
                            @endif
                        </td>
                        <td>{{ $buku->judul }}</td>
                        <td>{{ $buku->penulis }}</td>
                        <td>{{ "Rp. " .number_format($buku->harga, 2, ',', '.') }}</td>
                        <td>{{ \Carbon\Carbon::parse($buku->tgl_terbit)->format('d-m-Y') }}</td>
                        <td>
                            <a class="btn btn-outline-primary btn-sm" href="{{ route('galeri.buku', $buku->judul) }}" 
                                style="width: 70px;">
                                    Galeri
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="float-end">{{ $data_buku->links() }}</div>
    <br>
    <br>
    <table>
        <tr>
            <td><b>Jumlah buku</b></td>
            <td>&nbsp;:&nbsp;</td>
            <td>{{ $jumlah_data }}</td>
        </tr>
    </table>
@endsection