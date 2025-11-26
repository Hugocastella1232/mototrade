<?php

namespace Database\Factories;

use App\Models\Listing;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ListingFactory extends Factory
{
    protected $model = Listing::class;

    public function definition(): array
    {
        $brand = fake()->randomElement(['Yamaha','Honda','Kawasaki','BMW','Ducati']);
        $model = fake()->randomElement(['MT-07','CB500F','Z900','R1250R','Monster']);
        $title = "$brand $model " . fake()->numberBetween(2015, 2023);

        return [
            'user_id' => 1,
            'title' => $title,
            'slug' => Str::slug($title) . '-' . fake()->unique()->numberBetween(1000, 9999),
            'brand' => $brand,
            'model' => $model,
            'year' => fake()->numberBetween(2015, 2023),
            'km' => fake()->numberBetween(2000, 45000),
            'power_hp' => fake()->numberBetween(40, 160),
            'displacement_cc' => fake()->numberBetween(300, 1200),
            'fuel' => 'gasolina',
            'listing_condition' => fake()->randomElement(['usada', 'seminueva', 'nueva']),
            'price_eur' => fake()->numberBetween(1000, 20000),
            'status' => 0,
            'location' => fake()->city(),
            'description' => fake()->paragraph(),
            'image' => null,
            'published_at' => null
        ];
    }
}