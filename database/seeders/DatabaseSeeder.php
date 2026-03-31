<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\ArchitectProfile;
use App\Models\Portfolio;
use App\Models\Project;
use App\Models\Question;
use App\Models\Review;
use App\Models\Specialization;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. SPECILIZATIONS
        $specNames = [
            'Arsitektur Hunian',
            'Desain Interior',
            'Komersial & Retail',
            'Arsitektur Lanskap',
            'F&B (Cafe/Resto)',
            'Renovasi & Ekstensi',
            'Fasad & Eksterior'
        ];

        $specs = collect();
        foreach ($specNames as $name) {
            $specs->push(Specialization::create([
                'name' => $name,
                'description' => 'Fokus spesialisasi dalam bidang ' . strtolower($name),
            ]));
        }

        // 2. ADMIN USER
        User::create([
            'name' => 'Admin Ruang Temu',
            'email' => 'admin@ruangtemu.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // 3. MAIN CLIENT (For testing & pitching)
        $clientTanya = User::create([
            'name' => 'Michael Wibowo',
            'email' => 'klien@ruangtemu.com',
            'password' => Hash::make('password'),
            'role' => 'user', // Client role is user
            'is_active' => true,
            'profile_image' => 'https://images.unsplash.com/photo-1599566150163-29194dcaad36?auto=format&fit=crop&q=80&w=200&h=200',
        ]);

        $clientRina = User::create([
            'name' => 'Rina Paramita',
            'email' => 'rina.klien@example.com',
            'password' => Hash::make('password'),
            'role' => 'user', // Client role
            'is_active' => true,
            'profile_image' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&q=80&w=200&h=200',
        ]);

        $clientBudi = User::create([
            'name' => 'Budi Setiawan',
            'email' => 'budi.klien@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'is_active' => true,
            'profile_image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&q=80&w=200&h=200',
        ]);

        $clients = [$clientTanya, $clientRina, $clientBudi];

        // 4. ARCHITECTS & PROFILES

        $architectData = [
            [
                'user' => [
                    'name' => 'NUSA Architects',
                    'email' => 'arsitek@ruangtemu.com',
                    'password' => Hash::make('password'),
                    'role' => 'architect',
                    'is_active' => true,
                    'profile_image' => 'https://images.unsplash.com/photo-1513364776144-60967b0f800f?auto=format&fit=crop&q=80&w=400&h=400',
                ],
                'profile' => [
                    'specialization' => 'Mewah & Estetik',
                    'project_types' => ['Hunian', 'Komersial', 'F&B'],
                    'price_per_m2' => 250000,
                    'rating' => 4.9,
                    'location' => 'Jakarta Selatan',
                    'style' => 'Kontemporer Tropis',
                    'timeline' => '2-4 Bulan',
                ],
                'specs' => [0, 1, 4],
                'portfolios' => [
                    [
                        'title' => 'The Natura Villa Ubud',
                        'description' => 'Vila butik 4 kamar tidur dengan kolam renang infinity menghadap lahan hijau. Penggunaan material bambu pabrikasi dan beton ekspos menciptakan harmoni sempurna.',
                        'image' => 'https://images.unsplash.com/photo-1610641818989-c2051b5e2cfd?auto=format&fit=crop&q=80&w=1200'
                    ],
                    [
                        'title' => 'Senopati Office Space',
                        'description' => 'Renovasi fasad kantor 3 lantai dengan sirip alumunium dan vertical garden.',
                        'image' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&q=80&w=1200'
                    ]
                ]
            ],
            [
                'user' => [
                    'name' => 'Andra Laksana Studio',
                    'email' => 'andra@laksana.id',
                    'password' => Hash::make('password'),
                    'role' => 'architect',
                    'is_active' => true,
                    'profile_image' => 'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&q=80&w=400&h=400',
                ],
                'profile' => [
                    'specialization' => 'Desain Compact & Efisien',
                    'project_types' => ['Hunian', 'Renovasi'],
                    'price_per_m2' => 150000,
                    'rating' => 4.7,
                    'location' => 'Kota Bandung',
                    'style' => 'Modern Minimalis',
                    'timeline' => '1.5-3 Bulan',
                ],
                'specs' => [0, 5],
                'portfolios' => [
                    [
                        'title' => 'Compact House Dago',
                        'description' => 'Rumah tumbuh di lahan 72m2 dengan pemanfaatan mezzanine dan split level untuk memaksimalkan sirkulasi udara pegunungan alami.',
                        'image' => 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&q=80&w=1200'
                    ]
                ]
            ],
            [
                'user' => [
                    'name' => 'Rekatiga Desain',
                    'email' => 'halo@rekatiga.com',
                    'password' => Hash::make('password'),
                    'role' => 'architect',
                    'is_active' => true,
                    'profile_image' => 'https://images.unsplash.com/photo-1570295999919-56ceb5ecca61?auto=format&fit=crop&q=80&w=400&h=400',
                ],
                'profile' => [
                    'specialization' => 'Industrial Kreatif',
                    'project_types' => ['Komersial', 'F&B'],
                    'price_per_m2' => 200000,
                    'rating' => 4.8,
                    'location' => 'Surabaya',
                    'style' => 'Industrial / Brutalis',
                    'timeline' => '2-5 Bulan',
                ],
                'specs' => [2, 4, 1],
                'portfolios' => [
                    [
                        'title' => 'Kopi Seduh Darmo',
                        'description' => 'Kafe industrial modern yang mengubah gudang tua terbengkalai. Mengkonservasi dinding asli dan menambahkan atap kaca raksasa untuk pencahayaan.',
                        'image' => 'https://images.unsplash.com/photo-1554118811-1e0d58224f24?auto=format&fit=crop&q=80&w=1200'
                    ],
                    [
                        'title' => 'G-Walk Retail Container',
                        'description' => 'Kawasan kuliner terbuka menggunakan kontainer bekas yang didaur ulang secara estetik dengan kanopi membran canggih.',
                        'image' => 'https://images.unsplash.com/photo-1541887089-13db5231c6a2?auto=format&fit=crop&q=80&w=1200'
                    ]
                ]
            ],
            [
                'user' => [
                    'name' => 'Aulia & Partners',
                    'email' => 'hello@auliapartners.co.id',
                    'password' => Hash::make('password'),
                    'role' => 'architect',
                    'is_active' => true,
                    'profile_image' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&q=80&w=400&h=400',
                ],
                'profile' => [
                    'specialization' => 'Taman & Lanskap',
                    'project_types' => ['Lanskap', 'Komersial'],
                    'price_per_m2' => 125000,
                    'rating' => 4.6,
                    'location' => 'Bogor',
                    'style' => 'Tropis Organik',
                    'timeline' => '1-3 Bulan',
                ],
                'specs' => [3, 6],
                'portfolios' => [
                    [
                        'title' => 'Botanical Eco Park',
                        'description' => 'Desain lanskap taman kota seluas 2 hektar, memadukan jogging track dengan tanaman endemik Jawa Barat.',
                        'image' => 'https://images.unsplash.com/photo-1584483733009-328b9ab7d264?auto=format&fit=crop&q=80&w=1200'
                    ]
                ]
            ]
        ];

        $architects = [];

        foreach ($architectData as $data) {
            $user = User::create($data['user']);

            $profile = ArchitectProfile::create(array_merge(
                ['user_id' => $user->id],
                $data['profile']
            ));

            // Attach specializations
            $specIds = collect($data['specs'])->map(function ($idx) use ($specs) {
                return $specs[$idx]->id;
            });
            $profile->specializations()->attach($specIds);

            // Create portfolios
            foreach ($data['portfolios'] as $portData) {
                Portfolio::create([
                    'architect_profile_id' => $profile->id,
                    'title' => $portData['title'],
                    'description' => $portData['description'],
                    'image' => $portData['image'],
                ]);
            }

            $architects[] = $user;
        }

        // 5. PROJECTS AND REVIEWS
        // We will mock some completed projects (paid/completed status) and give real reviews

        $projectMockData = [
            [
                'client' => $clientTanya,
                'architect' => $architects[0], // NUSA
                'property_type' => 'Rumah Hunian',
                'area_size' => 200,
                'units' => 1,
                'status' => 'completed',
                'rating' => 5,
                'comment' => 'Desain NUSA sangat mengesankan! Memahami visi saya dengan cepat dan eksekusinya sempurna. Rumah terasa lega dan sirkulasi pernapasan kayunya luar biasa enak.',
            ],
            [
                'client' => $clientRina,
                'architect' => $architects[1], // Andra Laksana
                'property_type' => 'Renovasi',
                'area_size' => 60,
                'units' => 1,
                'status' => 'completed',
                'rating' => 4,
                'comment' => 'Sangat solutif untuk rumah subsidi kami yang terbatas ruang. Pembagian zoning ruang menjadi logis. Sedikit terlambat dalam penyelesaian denah awal tapi kami puas!',
            ],
            [
                'client' => $clientBudi,
                'architect' => $architects[2], // Rekatiga
                'property_type' => 'Komersial / Ruang usaha',
                'area_size' => 150,
                'units' => 1,
                'status' => 'completed',
                'rating' => 5,
                'comment' => 'Super kreatif! Anak-anak Rekatiga berhasil mengubah ruko usang menjadi kedai kopi paling hits dengan bajet masuk akal.',
            ],
            [
                'client' => $clientTanya,
                'architect' => $architects[3], // Aulia
                'property_type' => 'Lanskap',
                'area_size' => 80,
                'units' => 1,
                'status' => 'paid',
                'rating' => null, // Not reviewed yet
                'comment' => null,
            ]
        ];

        foreach ($projectMockData as $pm) {
            $pricePerM2 = $pm['architect']->architectProfile->price_per_m2;
            $project = Project::create([
                'user_id' => $pm['client']->id,
                'architect_id' => $pm['architect']->id,
                'property_type' => $pm['property_type'],
                'area_size' => $pm['area_size'],
                'units' => $pm['units'],
                'price_per_m2' => $pricePerM2,
                'total_price' => $pm['area_size'] * $pm['units'] * $pricePerM2,
                'status' => $pm['status'],
                'snap_token' => 'dummy-snap-token-' . Str::random(10),
            ]);

            if ($pm['rating']) {
                Review::create([
                    'project_id' => $project->id,
                    'architect_id' => $pm['architect']->id,
                    'client_id' => $pm['client']->id,
                    'rating' => $pm['rating'],
                    'comment' => $pm['comment'],
                ]);
            }
        }

        // 6. TANYA ARSITEK (QUESTIONS & ANSWERS)
        $q1 = Question::create([
            'client_id' => $clientTanya->id,
            'content' => 'Halo min, saya ada lahan 6x12 memanjang ke belakang, ingin bangun kos 6 pintu 2 lantai, apakah bujet desain rata-rata cukup di 20 juta saja?',
            'status' => 'answered',
            'architect_id' => $architects[1]->id, // Andra
            'claimed_at' => now()->subDays(2),
            'answered_at' => now()->subDay(),
        ]);

        Answer::create([
            'question_id' => $q1->id,
            'architect_id' => $architects[1]->id,
            'content' => 'Halo Bapak Michael! Untuk ukuran segitu bujet 20 juta sangat masuk akal bagi jasa arsitek pemula-menengah, asalkan lingkup kerjanya mungkin tidak termaksud 3D eksterior super detil atau gambar kerja struktural penuh. Sangat bisa diusahakan. Mari konsultasi gratis dengan kami!',
        ]);

        $q2 = Question::create([
            'client_id' => $clientRina->id,
            'content' => 'Arsitek di Jakarta Selatan ada yang bisa renovasi ruko setengah jadi menjadi klinik kecantikan? Temanya clean minimalis putih ala Korea.',
            'status' => 'claimed',
            'architect_id' => $architects[0]->id, // NUSA
            'claimed_at' => now()->subHours(2),
        ]);

        // Belum dijawab tap sudah claimed

        Question::create([
            'client_id' => $clientBudi->id,
            'content' => 'Saya pusing bocor dak beton terus menerus, enaknya ditambal pakai waterproofing merk apa ya kalau cuaca ekstrim? Atau wajib pasang atap kanopi baja ringan di atasnya?',
            'status' => 'open',
        ]);

        // 7. FOLLOWS (Favorite Architects)
        $clientTanya->followingArchitects()->attach($architects[0]->id);
        $clientTanya->followingArchitects()->attach($architects[2]->id);
    }
}
