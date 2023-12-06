<x-app-layout>
    @extends('layouts.layout')

    @section('title', 'Pencarian Buku')

    @section('content')
        @if(Session::has('pesan'))
            <div class="alert alert-success">{{Session::get('pesan')}}</div>
        @endif
        @if(Session::has('pesanUpdate'))
            <div class="alert alert-success">{{Session::get('pesanUpdate')}}</div>
        @endif
        @if(Session::has('pesanDelete'))
            <div class="alert alert-success">{{Session::get('pesanDelete')}}</div>
        @endif
        <div class="py-5 text-center">
            <h2>Hasil Pencarian Data Buku</h2>
        </div>
        
        <div class="container px-0 mb-3">
            <div class="row align-items-start">
                <div class="col">
                    @if (Auth::check() && Auth::user()->role == 'admin')
                        <a class="btn btn-primary" href={{ route('buku.create') }}><b>TAMBAH BUKU</b></a>
                    @endif
                </div>
                <div class="col"></div>
                <div class="col text-end">
                    <form action="{{ route('buku.search') }}" method="get">
                        @csrf
                        <input type="text" name="kata" class="form-control" placeholder="Cari ..." 
                        style="display: inline; float: right;">
                    </form>
                </div>
            </div>
        </div>
        
        @if(count($data_buku))
            <div class="alert alert-success">Ditemukan <strong>{{ count($data_buku) }}</strong> data dengan kata: <strong>{{ $cari }}</strong></div>
        @else 
            <div class="alert alert-warning"><h4>Data {{ $cari }} tidak ditemukan</h4>
            <a href="/dashboard" class="btn btn-warning">Kembali</a></div>
        @endif
        <div class="table-responsive">
            <table class="table table-borderless table-hover">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Gambar Sampul</th>
                        <th>Judul Buku</th>
                        <th>Penulis</th>
                        <th>Harga</th>
                        <th>Tanggal Terbit</th>
                        <th class="col-1 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data_buku as $buku)
                        <tr>
                            <td>{{ ++$no }}</td>
                            <td>
                                @if($buku->filepath)
                                    <div class="relative">
                                        <img class="object-cover object-center rounded-2" src="{{ asset($buku->filepath) }}" alt=""/>
                                    </div>
                                @endif
                            </td>
                            <td>{{ $buku->judul }}</td>
                            <td>{{ $buku->penulis }}</td>
                            <td>{{ "Rp. " .number_format($buku->harga, 2, ',', '.') }}</td>
                            <td>{{ \Carbon\Carbon::parse($buku->tgl_terbit)->format('d-m-Y') }}</td>
                            <td>
                                <div class="container-fluid align-items-start">
                                    @if (Auth::check() && Auth::user()->role == 'admin')
                                        <div class="col-auto">
                                            <form action="{{ route('buku.destroy', $buku->id) }}" method="post">@csrf 
                                                <button class="btn btn-danger btn-sm mb-1" onclick="return confirm('Yakin mau dihapus?')" 
                                                style="width: 70px;">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                        <div class="col-auto">
                                            <a class="btn btn-primary btn-sm mb-1" href="{{ route('buku.edit', $buku->id) }}" 
                                            style="width: 70px;">
                                                Edit
                                            </a>
                                        </div>
                                    @endif
                                    <div class="col-auto">
                                        <a class="btn btn-outline-secondary btn-sm" href="{{ route('galeri.buku', $buku->judul) }}" 
                                        style="width: 70px;">
                                            Detail
                                        </a>
                                    </div>
                                </div>
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
            <tr>
                <td><b>Total harga</b></td>
                <td>&nbsp;:&nbsp;</td>
                <td>{{ "Rp " .number_format($total_harga, 2, ',', '.') }}</td>
            </tr>
        </table>
    @endsection
</x-app-layout>