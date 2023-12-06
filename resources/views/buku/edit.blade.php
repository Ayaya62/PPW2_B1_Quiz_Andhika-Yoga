<x-app-layout>
    @extends('layouts.layout')

    @section('content')
        <h4 class="py-4 text-center"><b>Edit Data Buku</b></h4>
        @if (count($errors) > 0)
            <ul class="alert alert-danger px-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <section class="w-100 d-flex justify-content-center pb-4">
            <form action="{{route('buku.update',$buku->id)}}" method="POST" enctype="multipart/form-data" style="width: 40rem;">
                @csrf
                <!-- Judul buku -->
                <div class="form-outline mb-4">
                    <label class="form-label" for="form2Example1" style="margin-left: 0px;">Judul buku</label>
                    <input type="text" class="form-control" name="judul" id="judul" value="{{$buku->judul}}">
                <div class="form-notch"><div class="form-notch-leading" style="width: 9px;"></div><div class="form-notch-middle" style="width: 88.8px;"></div><div class="form-notch-trailing"></div></div></div>
                <!-- Penulis -->
                <div class="form-outline mb-4">
                    <label class="form-label" for="form2Example1" style="margin-left: 0px;">Penulis</label>
                    <input type="text" class="form-control" name="penulis" id="penulis" value="{{$buku->penulis}}">
                <div class="form-notch"><div class="form-notch-leading" style="width: 9px;"></div><div class="form-notch-middle" style="width: 88.8px;"></div><div class="form-notch-trailing"></div></div></div>
                <!-- Harga -->
                <div class="form-outline mb-4">
                    <label class="form-label" for="form2Example1" style="margin-left: 0px;">Harga</label>
                    <input type="text" class="form-control" name="harga" id="harga" value="{{$buku->harga}}">
                <div class="form-notch"><div class="form-notch-leading" style="width: 9px;"></div><div class="form-notch-middle" style="width: 88.8px;"></div><div class="form-notch-trailing"></div></div></div>
                <!-- Tanggal terbit -->
                <div class="form-outline mb-4">
                    <label class="form-label" for="form2Example1" style="margin-left: 0px;">Tanggal terbit</label>
                    <input type="date" class="form-control" name="tgl_terbit" id="tgl_terbit" value="{{$buku->tgl_terbit}}">
                <div class="form-notch"><div class="form-notch-leading" style="width: 9px;"></div><div class="form-notch-middle" style="width: 88.8px;"></div><div class="form-notch-trailing"></div></div></div>
                <!-- Thumbnail -->
                <div class="form-outline mb-4">
                    <label class="form-label" for="form2Example1" style="margin-left: 0px;">Thumbnail</label>
                    <input type="file" class="form-control" name="thumbnail" id="thumbnail">
                <div class="form-notch"><div class="form-notch-leading" style="width: 9px;"></div><div class="form-notch-middle" style="width: 88.8px;"></div><div class="form-notch-trailing"></div></div></div>
                <!-- Gallery -->
                <div class="form-outline mb-4">
                    <label class="form-label" for="form2Example1" style="margin-left: 0px;">Gallery</label>
                    <div id="fileinput_wrapper"></div>
                        <div class="d-grid">
                            <a class="btn btn-outline-secondary my-2" href="javascript:void(0);" id="tambah" onclick="addFileInput()">
                                <i class="bi bi-plus-circle-fill"></i> Tambah
                            </a>
                        </div>
                        <script type="text/javascript">
                            function addFileInput () {
                                var div = document.getElementById('fileinput_wrapper');
                                div.innerHTML += '<div class="input-group my-1"><input type="file" class="form-control" name="gallery[]" id="gallery"></div>';
                            };
                        </script>
                <div class="form-notch"><div class="form-notch-leading" style="width: 9px;"></div><div class="form-notch-middle" style="width: 88.8px;"></div><div class="form-notch-trailing"></div></div></div>
                
                <div class="container-fluid">
                    <div class="row align-items-start gap-3">
                        @foreach($buku->galleries()->get() as $gallery)
                            <div class="col-auto px-0 position-relative">
                                <a href="{{ asset($gallery->path) }}" data-lightbox="image-1" data-title="{{ $gallery->keterangan }}">
                                    <img src="{{ asset($gallery->path) }}" class="rounded-2" alt="" width="200"/>
                                </a>
                                <a 
                                    href="{{ route('buku.deleteGallery', $gallery->id) }}" 
                                    class="btn btn-dark btn-sm shadow rounded-circle" 
                                    style="position: absolute; top: 10px; right: 10px;">
                                    <i class="bi bi-x-lg"></i>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Button -->
                <div class="d-grid gap-2 mt-5">
                    <button class="btn btn-primary" type="submit">SIMPAN</button>
                    <a class="btn btn-outline-danger" href="/dashboard">BATAL</a>
                </div>
            </form>
        </section>
    @endsection
</x-app-layout>