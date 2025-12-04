<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Listing;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'Admin Hugo',
            'email' => 'hugo.admin@example.com',
            'password' => bcrypt('admin12345'),
            'is_admin' => true
        ]);

        $user = \App\Models\User::factory()->create([
            'name' => 'Hugooo',
            'email' => 'hugocastella@gmail.com',
            'password' => bcrypt('hugo123456'),
            'is_admin' => false
        ]);

        $motos = [
            [
                'title' => 'Honda CB500F 2021',
                'slug' => 'honda-cb500f-2021',
                'brand' => 'Honda',
                'model' => 'CB500F',
                'year' => 2021,
                'km' => 12000,
                'power_hp' => 47,
                'displacement_cc' => 471,
                'fuel' => 'gasolina',
                'listing_condition' => 'seminueva',
                'price_eur' => 5600,
                'image' => 'motos/honda-cb500f.jpg',
                'location' => 'Madrid',
                'description' => 'Moto ágil y económica, ideal para ciudad.'
            ],
            [
                'title' => 'Yamaha R7 2022',
                'slug' => 'yamaha-r7-2022',
                'brand' => 'Yamaha',
                'model' => 'R7',
                'year' => 2022,
                'km' => 8000,
                'power_hp' => 73,
                'displacement_cc' => 689,
                'fuel' => 'gasolina',
                'listing_condition' => 'seminueva',
                'price_eur' => 8700,
                'image' => 'motos/yamaha-r7.jpg',
                'location' => 'Barcelona',
                'description' => 'Deportiva ligera, perfecta para carretera y circuito.'
            ],
            [
                'title' => 'Kawasaki Z900 2021',
                'slug' => 'kawasaki-z900-2021',
                'brand' => 'Kawasaki',
                'model' => 'Z900',
                'year' => 2021,
                'km' => 15000,
                'power_hp' => 125,
                'displacement_cc' => 948,
                'fuel' => 'gasolina',
                'listing_condition' => 'usada',
                'price_eur' => 9500,
                'image' => 'motos/kawasaki-z900.jpg',
                'location' => 'Valencia',
                'description' => 'Naked potente y divertida, ideal para ciudad y carretera.'
            ],
            [
                'title' => 'BMW R1250GS 2020',
                'slug' => 'bmw-r1250gs-2020',
                'brand' => 'BMW',
                'model' => 'R1250GS',
                'year' => 2020,
                'km' => 22000,
                'power_hp' => 136,
                'displacement_cc' => 1254,
                'fuel' => 'gasolina',
                'listing_condition' => 'usada',
                'price_eur' => 15500,
                'image' => 'motos/bmw-r1250gs.jpg',
                'location' => 'Bilbao',
                'description' => 'Trail de referencia, ideal para largos viajes.'
            ],
            [
                'title' => 'Suzuki GSX-R750 2019',
                'slug' => 'suzuki-gsxr750-2019',
                'brand' => 'Suzuki',
                'model' => 'GSX-R750',
                'year' => 2019,
                'km' => 18000,
                'power_hp' => 150,
                'displacement_cc' => 750,
                'fuel' => 'gasolina',
                'listing_condition' => 'usada',
                'price_eur' => 9900,
                'image' => 'motos/suzuki-gsxr750.jpg',
                'location' => 'Sevilla',
                'description' => 'Deportiva icónica con gran equilibrio.'
            ],
            [
                'title' => 'KTM 450 SX-F 2021',
                'slug' => 'ktm-450-sxf-2021',
                'brand' => 'KTM',
                'model' => '450 SX-F',
                'year' => 2021,
                'km' => 500,
                'power_hp' => 63,
                'displacement_cc' => 449,
                'fuel' => 'gasolina',
                'listing_condition' => 'nueva',
                'price_eur' => 9300,
                'image' => 'motos/ktm-450sxf.jpg',
                'location' => 'Granada',
                'description' => 'Motocross de competición con gran rendimiento.'
            ],
            [
                'title' => 'Harley Iron 883 2018',
                'slug' => 'harley-iron883-2018',
                'brand' => 'Harley',
                'model' => 'Iron 883',
                'year' => 2018,
                'km' => 25000,
                'power_hp' => 51,
                'displacement_cc' => 883,
                'fuel' => 'gasolina',
                'listing_condition' => 'usada',
                'price_eur' => 7800,
                'image' => 'motos/harley-iron883.jpg',
                'location' => 'Málaga',
                'description' => 'Custom clásica con estilo inconfundible.'
            ],
            [
                'title' => 'Ducati Streetfighter V4 2022',
                'slug' => 'ducati-streetfighter-v4-2022',
                'brand' => 'Ducati',
                'model' => 'Streetfighter V4',
                'year' => 2022,
                'km' => 7000,
                'power_hp' => 208,
                'displacement_cc' => 1103,
                'fuel' => 'gasolina',
                'listing_condition' => 'seminueva',
                'price_eur' => 19500,
                'image' => 'motos/ducati-streetfighterv4.jpg',
                'location' => 'Alicante',
                'description' => 'Supernaked de altas prestaciones con motor de superbike.'
            ]
        ];

        foreach ($motos as $moto) {
            Listing::create(array_merge($moto, [
                'user_id' => $user->id,
                'status' => Listing::STATUS_APPROVED,
                'published_at' => now()
            ]));
        }
    }
}