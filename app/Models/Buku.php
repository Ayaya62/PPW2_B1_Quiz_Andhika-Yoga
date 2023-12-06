<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'buku';
    protected $fillable = ['judul', 'penulis', 'harga', 'tgl_terbit', 'filename', 'filepath'];
    protected $dates = ['tgl_terbit'];

    public function galleries(): HasMany
    {
        return $this->hasMany(Gallery::class);
    }

    public function rating()
    {
        return $this->hasMany(Rating::class);
    }

    public function averageRating()
    {
        return $this->rating->avg('rating');
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites', 'buku_id', 'user_id');
    }
}