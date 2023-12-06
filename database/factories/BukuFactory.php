<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Buku;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Buku>
 */
class BukuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Buku::class;

    public function definition(): array
    {
        return [
            'judul' => $this->faker->realText($maxNbChars=20),
            'penulis' => $this->faker->name(),
            'harga' => $this->faker->numberBetween($min=12000, $max=100000),
            'tgl_terbit' => $this->faker->date($format='Y-m-d', $max='now')
        ];
    }
}
