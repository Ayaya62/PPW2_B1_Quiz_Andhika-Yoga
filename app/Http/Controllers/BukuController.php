<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Buku;

use App\Models\Gallery;

use App\Models\Rating;

use App\Models\Favorites;

use Intervention\Image\Facades\Image;

class BukuController extends Controller
{
    public function index() {
        $batas = 5;
        $data_buku = Buku::orderBy('id', 'desc')->paginate($batas);
        $no = $batas * ($data_buku->currentPage() - 1);
        $jumlah_data = Buku::count('id');
        $total_harga = Buku::sum('harga');
        return view('buku.index', compact('data_buku', 'no', 'jumlah_data', 'total_harga'));
    }

    public function create() {
        return view('buku.create');
    }

    public function store(Request $request) {
        $this->validate($request, [
            'judul'         => 'required|string',
            'penulis'       => 'required|string|max:30',
            'harga'         => 'required|numeric',
            'tgl_terbit'    => 'required|date',
            'thumbnail'     => 'image|mimes:jpeg,jpg,png|max:2048'
        ]);

        $fileName = time().'_'.$request->thumbnail->getClientOriginalName();
        $filePath = $request->file('thumbnail')->storeAs('uploads', $fileName, 'public');
        
        Image::make(storage_path().'/app/public/uploads/'.$fileName)->fit(140,220)->save();

        $buku = Buku::create([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'harga' => $request->harga,
            'tgl_terbit' => $request->tgl_terbit,
            'filename' => $fileName,
            'filepath' => '/storage/' . $filePath
        ]);

        if ($request->file('gallery')) {
            foreach($request->file('gallery') as $key => $file) {
                $galleryFileName = time().'_'.$file->getClientOriginalName();
                $galleryFilePath = $file->storeAs('uploads', $galleryFileName, 'public');

                Image::make(storage_path().'/app/public/uploads/'.$galleryFileName)->fit(720,720)->save();

                $gallery = Gallery::create([
                    'nama_galeri' => $galleryFileName,
                    'path' => '/storage/'. $galleryFilePath,
                    'foto' => $galleryFileName,
                    'buku_id' => $buku->id
                ]);
            }
        }
        return redirect('/dashboard')->with('pesan', 'Data Buku Berhasil Disimpan');
    }

    public function destroy($id) {
        $buku = Buku::find($id);
        $buku->delete();
        return redirect('/dashboard')->with('pesanDelete', 'Buku Berhasil Dihapus');
    }

    public function edit($id) {
        $buku = Buku::find($id);
        return view('buku.edit', compact('buku'));
    }

    public function update(Request $request, $id) {
        $buku = Buku::find($id);

        if ($request->file('thumbnail')) {
            $request->validate([
                'thumbnail' => 'image|mimes:jpeg,jpg,png|max:2048'
            ]);

            $fileName = time().'_'.$request->thumbnail->getClientOriginalName();
            $filePath = $request->file('thumbnail')->storeAs('uploads', $fileName, 'public');
            
            Image::make(storage_path().'/app/public/uploads/'.$fileName)->fit(140,220)->save();
        }

        if ($request->file('gallery')) {
            foreach($request->file('gallery') as $key => $file) {
                $galleryFileName = time().'_'.$file->getClientOriginalName();
                $galleryFilePath = $file->storeAs('uploads', $galleryFileName, 'public');

                Image::make(storage_path().'/app/public/uploads/'.$galleryFileName)->fit(720,720)->save();

                $gallery = Gallery::create([
                    'nama_galeri' => $galleryFileName,
                    'path' => '/storage/'. $galleryFilePath,
                    'foto' => $galleryFileName,
                    'buku_id' => $id
                ]);
            }
        }
        
        if ($request->file('thumbnail')) {
            $buku->update([
                'judul' => $request->judul,
                'penulis' => $request->penulis,
                'harga' => $request->harga,
                'tgl_terbit' => $request->tgl_terbit,
                'filename' => $fileName,
                'filepath' => '/storage/' . $filePath
            ]);
        } else {
            if ($buku->filepath) {
                $buku->update([
                    'judul' => $request->judul,
                    'penulis' => $request->penulis,
                    'harga' => $request->harga,
                    'tgl_terbit' => $request->tgl_terbit,
                    'filename' => $buku->filename,
                    'filepath' => $buku->filepath
                ]);
            }
        }
        return redirect('/dashboard')->with('pesanUpdate', 'Data Buku Berhasil Diubah');
    }

    public function search(Request $request) {
        $batas = 5;
        $cari = $request->kata;
        $data_buku = Buku::where('judul', 'like', "%".$cari."%")->orwhere('penulis', 'like', "%".$cari."%")->paginate($batas);
        $jumlah_data = $data_buku->count();
        $no = $batas * ($data_buku->currentPage() - 1);
        $total_harga = $data_buku->sum('harga');
        return view('buku.search', compact('data_buku', 'total_harga', 'no', 'jumlah_data', 'cari'));
    }

    public function deleteGallery($id) {
        $gallery = Gallery::findOrFail($id);

        $gallery->delete();

        return redirect()->back();
    }

    public function listBuku() {
        $batas = 5;
        $data_buku = Buku::orderBy('id', 'desc')->paginate($batas);
        $no = $batas * ($data_buku->currentPage() - 1);
        $jumlah_data = Buku::count('id');
        return view('buku.list_buku', compact('data_buku', 'no', 'jumlah_data'));
    }

    public function galBuku($title) {
        $buku = Buku::where('judul', $title)->first();
        $galeri = $buku->galleries()->orderBy('id', 'desc')->paginate(6);
        return view('buku.detail-buku', compact('buku', 'galeri'));
    }

    public function rate(Request $request, $id) {
        $buku = Buku::find($id);
    
        $existingRating = Rating::where('user_id', auth()->user()->id)
            ->where('buku_id', $buku->id)
            ->first();
    
        if ($existingRating) {
            return redirect()->back()->with('error', 'Anda sudah memberikan rating untuk buku ini.');
        }
    
        $rating = new Rating([
            'user_id' => auth()->user()->id,
            'rating' => $request->rating,
        ]);
    
        $buku->rating()->save($rating);
    
        return redirect()->back()->with('success', 'Rating berhasil disimpan.');
    }

    public function addToFavorites(Request $request, $id)
    {
        $buku = Buku::find($id);
    
        $existingFavorites = Favorites::where('user_id', auth()->user()->id)
            ->where('buku_id', $buku->id)
            ->first();

        if ($existingFavorites) {
            return redirect()->back()->with('error', 'Buku sudah ada di favorit Anda.');
        }

        $buku->favoritedBy()->attach(auth()->user()->id);
        return redirect("/buku/myfavorite")->with('success', 'Buku ditambahkan ke favorit.');
    }
}