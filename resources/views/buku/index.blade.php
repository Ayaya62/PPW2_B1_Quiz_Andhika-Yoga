<x-app-layout>
    @extends('layouts.layout')

    @section('title', 'Koleksi Buku')

    @section('content')
        @if(Session::has('pesan'))
            <div class="alert alert-success">{{Session::get('pesan')}}</div>
        @endif
        @if(Session::has('success'))
            <div class="alert alert-success">{{Session::get('success')}}</div>
        @endif
        @if(Session::has('pesanUpdate'))
            <div class="alert alert-success">{{Session::get('pesanUpdate')}}</div>
        @endif
        @if(Session::has('pesanDelete'))
            <div class="alert alert-success">{{Session::get('pesanDelete')}}</div>
        @endif
        <div class="py-5 text-center">
            <h2><b>LIST BUKU</b></h2>
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

        <div class="table-responsive">
            <table class="table table-stripped">
                <thead class="table-primary">
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
                                <div class="container flex">
                                    @if (Auth::check() && Auth::user()->role == 'admin')
                                        <div class="col-auto m-1">
                                            <form action="{{ route('buku.destroy', $buku->id) }}" method="post">@csrf 
                                                <button class="btn btn-danger" onclick="return confirm('Yakin mau dihapus?')">
                                                <svg width="24" height="24" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <g clip-path="url(#clip0_1222_5675)">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.76256 2.01256C6.09075 1.68437 6.53587 1.5 7 1.5C7.46413 1.5 7.90925 1.68437 8.23744 2.01256C8.4448 2.21993 8.59475 2.47397 8.67705 2.75H5.32295C5.40525 2.47397 5.5552 2.21993 5.76256 2.01256ZM3.78868 2.75C3.89405 2.07321 4.21153 1.44227 4.7019 0.951903C5.3114 0.34241 6.13805 0 7 0C7.86195 0 8.6886 0.34241 9.2981 0.951903C9.78847 1.44227 10.106 2.07321 10.2113 2.75H13C13.4142 2.75 13.75 3.08579 13.75 3.5C13.75 3.91422 13.4142 4.25 13 4.25H12V12.5C12 12.8978 11.842 13.2794 11.5607 13.5607C11.2794 13.842 10.8978 14 10.5 14H3.5C3.10217 14 2.72064 13.842 2.43934 13.5607C2.15804 13.2794 2 12.8978 2 12.5V4.25H1C0.585786 4.25 0.25 3.91422 0.25 3.5C0.25 3.08579 0.585786 2.75 1 2.75H3.78868ZM5 5.87646C5.34518 5.87646 5.625 6.15629 5.625 6.50146V10.503C5.625 10.8481 5.34518 11.128 5 11.128C4.65482 11.128 4.375 10.8481 4.375 10.503V6.50146C4.375 6.15629 4.65482 5.87646 5 5.87646ZM9.625 6.50146C9.625 6.15629 9.34518 5.87646 9 5.87646C8.65482 5.87646 8.375 6.15629 8.375 6.50146V10.503C8.375 10.8481 8.65482 11.128 9 11.128C9.34518 11.128 9.625 10.8481 9.625 10.503V6.50146Z" fill="white"/>
                                                    </g>
                                                    <defs>
                                                    <clipPath id="clip0_1222_5675">
                                                    <rect width="24" height="24" fill="white"/>
                                                    </clipPath>
                                                    </defs>
                                                    </svg>                                                    
                                                </button>
                                            </form>
                                        </div>
                                        <div class="col-auto m-1">
                                            <a class="btn btn-success" href="{{ route('buku.edit', $buku->id) }}">
                                            <svg width="24" height="24" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <g clip-path="url(#clip0_1222_5633)">
                                                <path d="M10.715 -0.000976562C10.5152 -0.000976562 10.3174 0.0389464 10.1332 0.116448C9.95019 0.193468 9.78428 0.306058 9.64512 0.447676L1.40732 8.64549C1.34616 8.70635 1.30179 8.782 1.27853 8.86508L0.0185299 13.3651C-0.0301752 13.539 0.0187291 13.7257 0.146458 13.8535C0.274188 13.9812 0.46088 14.0301 0.634827 13.9814L5.13483 12.7214C5.21791 12.6981 5.29356 12.6537 5.35442 12.5926L13.5521 4.3549L13.5535 4.35355C13.6934 4.21438 13.8045 4.04896 13.8804 3.86676C13.9566 3.68398 13.9958 3.48792 13.9958 3.2899C13.9958 3.09188 13.9566 2.89582 13.8804 2.71303C13.8045 2.53083 13.6934 2.3654 13.5535 2.22624L13.5521 2.2249L11.7859 0.448721C11.6466 0.306611 11.4803 0.193657 11.2968 0.116448C11.1126 0.0389464 10.9148 -0.000976562 10.715 -0.000976562Z" fill="white"/>
                                                </g>
                                                <defs>
                                                <clipPath id="clip0_1222_5633">
                                                <rect width="24" height="24" fill="white"/>
                                                </clipPath>
                                                </defs>
                                                </svg>
                                                
                                            </a>
                                        </div>
                                    @endif
                                    <div class="col-auto m-1">
                                        <a class="btn btn-primary" href="{{ route('galeri.buku', $buku->judul) }}">
                                            <svg width="24" height="24" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M2.9327 3.49099C4.0559 2.68177 5.4556 2 7 2C8.54441 2 9.9441 2.68177 11.0673 3.49099C12.1946 4.30314 13.087 5.27496 13.6272 5.92789L13.6317 5.93342C13.873 6.23362 14 6.61404 14 7.00006C14 7.38607 13.873 7.7665 13.6317 8.0667L13.6272 8.07223C13.087 8.72515 12.1946 9.69698 11.0673 10.5091C9.9441 11.3183 8.54441 12.0001 7 12.0001C5.4556 12.0001 4.0559 11.3183 2.9327 10.5091C1.80544 9.69698 0.913028 8.72515 0.37279 8.07223L0.36828 8.0667C0.127025 7.7665 0 7.38607 0 7.00006C0 6.61404 0.127025 6.23362 0.36828 5.93342L0.37279 5.92789C0.913028 5.27496 1.80544 4.30314 2.9327 3.49099ZM7 9.25C8.24264 9.25 9.25 8.24264 9.25 7C9.25 5.75736 8.24264 4.75 7 4.75C5.75736 4.75 4.75 5.75736 4.75 7C4.75 8.24264 5.75736 9.25 7 9.25Z" fill="white"/>
                                                </svg>
                                                
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