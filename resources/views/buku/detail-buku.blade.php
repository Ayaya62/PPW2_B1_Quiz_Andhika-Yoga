<x-app-layout>
    @extends('layouts.layout')

    @section('content')
        @if(Session::has('success'))
            <div class="alert alert-success">{{Session::get('success')}}</div>
        @endif
        @if(Session::has('error'))
            <div class="alert alert-danger">{{Session::get('error')}}</div>
        @endif
        <section class="w-100 d-flex justify-content-center py-4">
            <div style="width: 45rem;">
                <div class="container-fluid my-5 px-0">
                    <div class="row">
                        <div class="col-auto">
                            @if($buku->filepath)
                                <div class="relative h-10 w-10">
                                    <img class="rounded-2" style="width: 110%" src="{{ asset($buku->filepath) }}" alt=""/>
                                </div>
                            @endif
                        </div>
                        <div class="col ps-4 align-items-center">
                            <h1><b>{{ $buku->judul }}</b></h1>
                            <form method="post" action="{{ route('buku.favorite', $buku->id) }}">
                                @csrf
                                <button class="mb-3 btn btn-sm btn-outline-primary" type="submit"><i class="bi bi-bookmark"></i> Simpan ke daftar favorit</button>
                            </form>
                            <table class="table table-hover">
                                <tr>
                                    <td>Penulis</td>
                                    <td>{{ $buku->penulis }}</td>
                                </tr>
                                <tr>
                                    <td>Harga</td>
                                    <td>{{ "Rp. " .number_format($buku->harga, 2, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td>Tanggal terbit</td>
                                    <td>{{ $buku->tgl_terbit }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <h5 class="text-center mb-3"><b>R A T I N G</b></h5>
                <hr>
                <section class="table-responsive mb-5">
                    <table class="table">
                        <tr>
                            <td>Rating</td>
                            <td><b id="rating">{{ $buku->averageRating() }}</b></td>
                            <script type="text/javascript">
                                var div = document.getElementById('rating');
                                if(div.innerHTML == "") {
                                    div.innerHTML = "Rating is not available."
                                }
                            </script>
                        </tr>
                        <tr>
                            <form action="{{ route('buku.rate', $buku->id) }}" method="post">
                                @csrf
                                <td><label for="rating">Berikan penilaian</label></td>
                                <td>
                                    <select class="me-2" name="rating" id="rating">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                    <br>
                                    <input class="btn btn-sm btn-outline-primary mt-2" type="submit" value="Simpan Penilaian" style="width: 100%;">
                                </td>
                            </form>
                        </tr>
                    </table>
                </section>

                <h5 class="text-center mb-3"><b>G A L E R I</b></h5>
                <hr>
                <div class="row align-items-start gap-3">
                    @foreach ($galeri as $data)
                        <div class="col-auto">
                            <a href="{{ asset($data->path) }}" data-lightbox="image-1" data-title="{{ $data->keterangan }}">
                                <img src="{{ asset($data->path) }}" class="rounded-2" style="width: 213px; height= 150px;">
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="float-end mt-3">{{ $galeri->links() }}</div>
            </div>
        </section>
    @endsection
</x-app-layout>