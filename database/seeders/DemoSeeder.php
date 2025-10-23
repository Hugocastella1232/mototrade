<?php 

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $admin = \App\Models\User::factory()->create([
            'name' => 'Admin Hugo',
            'email' => 'hugo.admin@example.com',
            'password' => bcrypt('admin12345'),
            'is_admin' => true,
        ]);

        $s1 = \App\Models\User::factory()->create([
            'name' => 'Vendedor 1',
            'email' => 'v1@example.com',
            'password' => bcrypt('password'),
        ]);

        \App\Models\Listing::create([
            'user_id' => $s1->id,
            'title' => 'Honda CB500F 2021',
            'slug' => 'honda-cb500f-2021',
            'brand' => 'Honda',
            'model' => 'CB500F',
            'year' => 2021,
            'km' => 12000,
            'power_hp' => 47,
            'displacement_cc' => 471,
            'fuel' => 'gasolina',
            'condition' => 'seminueva',
            'price_cents' => 560000,
            'status' => 'published',
            'published_at' => now(),
            'location' => 'Madrid',
            'description' => 'Moto ágil y económica, ideal para ciudad.',
            'image' => 'motos/honda-cb500f.jpg',
        ]);

        \App\Models\Listing::create([
            'user_id' => $s1->id,
            'title' => 'Yamaha R7 2022',
            'slug' => 'yamaha-r7-2022',
            'brand' => 'Yamaha',
            'model' => 'R7',
            'year' => 2022,
            'km' => 8000,
            'power_hp' => 73,
            'displacement_cc' => 689,
            'fuel' => 'gasolina',
            'condition' => 'seminueva',
            'price_cents' => 870000,
            'status' => 'published',
            'published_at' => now(),
            'location' => 'Barcelona',
            'description' => 'Deportiva ligera, perfecta para carretera y circuito.',
            'image' => 'motos/yamaha-r7.jpg',
        ]);

        \App\Models\Listing::create([
            'user_id' => $s1->id,
            'title' => 'Kawasaki Z900 2021',
            'slug' => 'kawasaki-z900-2021',
            'brand' => 'Kawasaki',
            'model' => 'Z900',
            'year' => 2021,
            'km' => 15000,
            'power_hp' => 125,
            'displacement_cc' => 948,
            'fuel' => 'gasolina',
            'condition' => 'usada',
            'price_cents' => 950000,
            'status' => 'published',
            'published_at' => now(),
            'location' => 'Valencia',
            'description' => 'Naked potente y divertida, ideal para ciudad y carretera.',
            'image' => 'motos/kawasaki-z900.jpg',
        ]);

        \App\Models\Listing::create([
            'user_id' => $s1->id,
            'title' => 'BMW R1250GS 2020',
            'slug' => 'bmw-r1250gs-2020',
            'brand' => 'BMW',
            'model' => 'R1250GS',
            'year' => 2020,
            'km' => 22000,
            'power_hp' => 136,
            'displacement_cc' => 1254,
            'fuel' => 'gasolina',
            'condition' => 'usada',
            'price_cents' => 1550000,
            'status' => 'published',
            'published_at' => now(),
            'location' => 'Bilbao',
            'description' => 'Trail de referencia, ideal para largos viajes.',
            'image' => 'motos/bmw-r1250gs.jpg',
        ]);

        \App\Models\Listing::create([
            'user_id' => $s1->id,
            'title' => 'Suzuki GSX-R750 2019',
            'slug' => 'suzuki-gsxr750-2019',
            'brand' => 'Suzuki',
            'model' => 'GSX-R750',
            'year' => 2019,
            'km' => 18000,
            'power_hp' => 150,
            'displacement_cc' => 750,
            'fuel' => 'gasolina',
            'condition' => 'usada',
            'price_cents' => 990000,
            'status' => 'published',
            'published_at' => now(),
            'location' => 'Sevilla',
            'description' => 'Deportiva icónica con gran equilibrio.',
            'image' => 'motos/suzuki-gsxr750.jpg',
        ]);

        \App\Models\Listing::create([
            'user_id' => $s1->id,
            'title' => 'KTM 450 SX-F 2021',
            'slug' => 'ktm-450-sxf-2021',
            'brand' => 'KTM',
            'model' => '450 SX-F',
            'year' => 2021,
            'km' => 500,
            'power_hp' => 63,
            'displacement_cc' => 449,
            'fuel' => 'gasolina',
            'condition' => 'nueva',
            'price_cents' => 930000,
            'status' => 'published',
            'published_at' => now(),
            'location' => 'Granada',
            'description' => 'Motocross de competición con gran rendimiento.',
            'image' => 'motos/ktm-450sxf.jpg',
        ]);

        \App\Models\Listing::create([
            'user_id' => $s1->id,
            'title' => 'Harley Iron 883 2018',
            'slug' => 'harley-iron883-2018',
            'brand' => 'Harley',
            'model' => 'Iron 883',
            'year' => 2018,
            'km' => 25000,
            'power_hp' => 51,
            'displacement_cc' => 883,
            'fuel' => 'gasolina',
            'condition' => 'usada',
            'price_cents' => 780000,
            'status' => 'published',
            'published_at' => now(),
            'location' => 'Málaga',
            'description' => 'Custom clásica con estilo inconfundible.',
            'image' => 'motos/harley-iron883.jpg',
        ]);

        \App\Models\Listing::create([
            'user_id' => $s1->id,
            'title' => 'Ducati Streetfighter V4 2022',
            'slug' => 'ducati-streetfighter-v4-2022',
            'brand' => 'Ducati',
            'model' => 'Streetfighter V4',
            'year' => 2022,
            'km' => 7000,
            'power_hp' => 208,
            'displacement_cc' => 1103,
            'fuel' => 'gasolina',
            'condition' => 'seminueva',
            'price_cents' => 1950000,
            'status' => 'published',
            'published_at' => now(),
            'location' => 'Alicante',
            'description' => 'Supernaked de altas prestaciones con motor de superbike.',
            'image' => 'motos/ducati-streetfighterv4.jpg',
        ]);
    }
}