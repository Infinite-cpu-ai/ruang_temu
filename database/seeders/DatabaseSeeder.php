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
        // Portfolio images (local)
        $homeImg = '/images/portofolios/house_mockup.jpg';
        $officeImg = '/images/portofolios/office_mockup.jpeg';

        // 1. SPECIALIZATIONS
        $specNames = [
            'Arsitektur Hunian',
            'Desain Interior',
            'Komersial & Retail',
            'Arsitektur Lanskap',
            'F&B (Cafe/Resto)',
            'Renovasi & Ekstensi',
            'Fasad & Eksterior',
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
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // 3. CLIENTS
        $clientTanya = User::create([
            'name' => 'Michael Wibowo',
            'email' => 'klien@ruangtemu.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'user',
            'is_active' => true,
            'is_premium' => true,
            'is_subscription_active' => true,
            'premium_expires_at' => now()->addMonths(3),
        ]);

        $clientRina = User::create([
            'name' => 'Rina Paramita',
            'email' => 'rina.klien@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'user',
            'is_active' => true,
            'is_premium' => true,
            'is_subscription_active' => true,
            'premium_expires_at' => now()->addMonths(2),
        ]);

        $clientBudi = User::create([
            'name' => 'Budi Setiawan',
            'email' => 'budi.klien@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'user',
            'is_active' => true,
            'is_premium' => true,
            'is_subscription_active' => true,
            'premium_expires_at' => now()->addMonth(),
        ]);

        $clients = [$clientTanya, $clientRina, $clientBudi];

        // 4. ARCHITECTS & PROFILES
        // ── Rumah Hunian Specialists (5) ──
        $architectData = [
            [
                'user' => [
                    'name' => 'Andra Matin',
                    'email' => 'andra.matin@ruangtemu.com',
                    'email_verified_at' => now(),
                    'password' => Hash::make('password'),
                    'role' => 'architect',
                    'is_active' => true,
                    'is_premium' => true,
                    'is_subscription_active' => true,
                    'premium_expires_at' => now()->addYear(),
                ],
                'profile' => [
                    'specialization' => 'Modern Tropis & Kontemporer',
                    'project_types' => ['Rumah Hunian', 'Vila', 'Renovasi'],
                    'price_per_m2' => 350000,
                    'rating' => 4.9,
                    'location' => 'Jakarta Selatan',
                    'style' => 'Kontemporer Tropis',
                    'timeline' => '3-6 Bulan',
                ],
                'specs' => [0, 1, 5],
                'type' => 'hunian',
                'portfolios' => [
                    ['title' => 'Rumah Alam Sutera Residence', 'description' => 'Hunian minimalis tropis 2 lantai dengan konsep open-plan living, kolam renang privat, dan taman vertikal.'],
                    ['title' => 'Villa Ubud Bamboo House', 'description' => 'Vila butik 4 kamar tidur dengan struktur bambu pabrikasi. Infinity pool menghadap sawah.'],
                    ['title' => 'Townhouse Cipete', 'description' => 'Cluster townhouse modern 3 unit dengan shared courtyard dan rooftop garden.'],
                    ['title' => 'Retreat House Puncak', 'description' => 'Rumah peristirahatan pegunungan dengan dinding kaca penuh dan fireplace batu alam.'],
                    ['title' => 'Compact House Kemang', 'description' => 'Rumah compact di lahan 90m2 dengan split level dan skylight untuk pencahayaan alami.'],
                    ['title' => 'Pavilion House Sentul', 'description' => 'Konsep pavilion terpisah untuk area tidur dan living, dihubungkan oleh taman air.'],
                ],
            ],
            [
                'user' => [
                    'name' => 'Kengo Kuma',
                    'email' => 'kengo.kuma@ruangtemu.com',
                    'email_verified_at' => now(),
                    'password' => Hash::make('password'),
                    'role' => 'architect',
                    'is_active' => true,
                    'is_premium' => true,
                    'is_subscription_active' => true,
                    'premium_expires_at' => now()->addYear(),
                ],
                'profile' => [
                    'specialization' => 'Natural Material & Zen Design',
                    'project_types' => ['Rumah Hunian', 'Vila', 'Cultural Space'],
                    'price_per_m2' => 500000,
                    'rating' => 5.0,
                    'location' => 'Jakarta Pusat',
                    'style' => 'Japanese Zen Modern',
                    'timeline' => '4-8 Bulan',
                ],
                'specs' => [0, 1, 6],
                'type' => 'hunian',
                'portfolios' => [
                    ['title' => 'Timber Lattice House', 'description' => 'Fasad kisi-kisi kayu cedar yang menciptakan permainan cahaya dinamis sepanjang hari.'],
                    ['title' => 'Garden Pavilion Sentul', 'description' => 'Paviliun taman dengan atap melengkung dari bambu laminasi. Ruang meditasi.'],
                    ['title' => 'Zen Courtyard House', 'description' => 'Rumah dengan inner courtyard bergaya zen garden, batu kerikil, dan maple Jepang.'],
                    ['title' => 'Floating Tea House', 'description' => 'Ruang teh yang mengambang di atas kolam refleksi. Struktur kayu tanpa paku.'],
                    ['title' => 'Bamboo Canopy Residence', 'description' => 'Kesatuan antara arsitektur dan alam dengan kanopi bambu yang menaungi seluruh bangunan.'],
                    ['title' => 'Light Wood Villa', 'description' => 'Vila dengan selubung kayu ringan yang bisa dibuka tutup mengikuti cuaca dan musim.'],
                ],
            ],
            [
                'user' => [
                    'name' => 'Realrich Sjarief',
                    'email' => 'realrich@ruangtemu.com',
                    'email_verified_at' => now(),
                    'password' => Hash::make('password'),
                    'role' => 'architect',
                    'is_active' => true,
                    'is_premium' => true,
                    'is_subscription_active' => true,
                    'premium_expires_at' => now()->addYear(),
                ],
                'profile' => [
                    'specialization' => 'Raw Architecture & Sustainable',
                    'project_types' => ['Rumah Hunian', 'Renovasi', 'Lanskap'],
                    'price_per_m2' => 275000,
                    'rating' => 4.8,
                    'location' => 'Jakarta Barat',
                    'style' => 'Raw / Brutalis Tropis',
                    'timeline' => '3-5 Bulan',
                ],
                'specs' => [0, 3, 5],
                'type' => 'hunian',
                'portfolios' => [
                    ['title' => 'Omah Boto Semarang', 'description' => 'Rumah bata merah ekspos dengan void besar. Sirkulasi udara alami tanpa AC.'],
                    ['title' => 'Concrete Frame House', 'description' => 'Struktur beton ekspos dengan tanaman merambat sebagai selubung hijau alami.'],
                    ['title' => 'Brick Garden House', 'description' => 'Hunian dengan 70% area taman. Dinding bata daur ulang dari pabrik gula tua.'],
                    ['title' => 'Rumah Kayu Recycled', 'description' => 'Seluruh material kayu berasal dari kapal nelayan dan rumah Joglo yang dibongkar.'],
                    ['title' => 'Earth Shelter Home', 'description' => 'Rumah semi-underground dengan atap tanah yang menyatu dengan kontur bukit.'],
                    ['title' => 'Ventilation House', 'description' => 'Eksperimen arsitektur dengan 12 jenis bukaan untuk ventilasi silang maksimal.'],
                ],
            ],
            [
                'user' => [
                    'name' => 'Bjarke Ingels',
                    'email' => 'bjarke.ingels@ruangtemu.com',
                    'email_verified_at' => now(),
                    'password' => Hash::make('password'),
                    'role' => 'architect',
                    'is_active' => true,
                    'is_premium' => true,
                    'is_subscription_active' => true,
                    'premium_expires_at' => now()->addYear(),
                ],
                'profile' => [
                    'specialization' => 'Futuristic & Hedonistic Sustainability',
                    'project_types' => ['Rumah Hunian', 'Vila', 'Mixed-Use'],
                    'price_per_m2' => 450000,
                    'rating' => 4.9,
                    'location' => 'Bali',
                    'style' => 'Futuristik Skandinavian',
                    'timeline' => '4-7 Bulan',
                ],
                'specs' => [0, 1, 6],
                'type' => 'hunian',
                'portfolios' => [
                    ['title' => 'Cliff House Uluwatu', 'description' => 'Rumah tebing 3 lantai dengan cantilever dramatis menghadap samudera.'],
                    ['title' => 'Spiral Garden House', 'description' => 'Hunian dengan ramp spiral menghubungkan semua lantai, taman kontinyu.'],
                    ['title' => 'Infinity Pool Villa', 'description' => 'Vila dengan kolam renang tanpa batas yang menyatu dengan cakrawala Bali.'],
                    ['title' => 'Solar Powered Residence', 'description' => 'Rumah net-zero energy dengan panel surya terintegrasi ke atap origami.'],
                    ['title' => 'Modular Beach House', 'description' => 'Hunian modular yang bisa diperluas. Setiap modul memiliki teras pantai privat.'],
                    ['title' => 'Rooftop Farm House', 'description' => 'Rumah dengan kebun produktif di rooftop seluas 200m2 untuk urban farming.'],
                ],
            ],
            [
                'user' => [
                    'name' => 'Achmad Tardiyana',
                    'email' => 'achmad.tardiyana@ruangtemu.com',
                    'email_verified_at' => now(),
                    'password' => Hash::make('password'),
                    'role' => 'architect',
                    'is_active' => true,
                    'is_premium' => true,
                    'is_subscription_active' => true,
                    'premium_expires_at' => now()->addYear(),
                ],
                'profile' => [
                    'specialization' => 'Smart Home & IoT Architecture',
                    'project_types' => ['Rumah Hunian', 'Renovasi', 'Smart Building'],
                    'price_per_m2' => 200000,
                    'rating' => 4.7,
                    'location' => 'Kota Bandung',
                    'style' => 'Modern Minimalis',
                    'timeline' => '2-4 Bulan',
                ],
                'specs' => [0, 1, 5],
                'type' => 'hunian',
                'portfolios' => [
                    ['title' => 'Smart Compact House Dago', 'description' => 'Rumah tumbuh di lahan 72m2 dengan sistem smart home terintegrasi penuh.'],
                    ['title' => 'Eco Residence Cimahi', 'description' => 'Perumahan cluster 12 unit dengan rainwater harvesting dan smart energy.'],
                    ['title' => 'IoT Villa Lembang', 'description' => 'Vila dengan otomasi penuh: lighting, HVAC, security, dan irrigation system.'],
                    ['title' => 'Passive House Bandung', 'description' => 'Rumah hemat energi 80% dengan insulasi optimal dan heat recovery ventilation.'],
                    ['title' => 'Nano House Project', 'description' => 'Eksperimen hunian 36m2 dengan furnitur transformable dan storage tersembunyi.'],
                    ['title' => 'Smart Garden Home', 'description' => 'Rumah dengan sistem IoT untuk monitoring dan perawatan taman otomatis.'],
                ],
            ],
            // ── Komersial Specialists (5) ──
            [
                'user' => [
                    'name' => 'Danny Wicaksono',
                    'email' => 'danny.wicaksono@ruangtemu.com',
                    'email_verified_at' => now(),
                    'password' => Hash::make('password'),
                    'role' => 'architect',
                    'is_active' => true,
                    'is_premium' => true,
                    'is_subscription_active' => true,
                    'premium_expires_at' => now()->addYear(),
                ],
                'profile' => [
                    'specialization' => 'Corporate & Office Design',
                    'project_types' => ['Komersial', 'Perkantoran', 'Co-Working Space'],
                    'price_per_m2' => 300000,
                    'rating' => 4.8,
                    'location' => 'Jakarta Selatan',
                    'style' => 'Kontemporer Profesional',
                    'timeline' => '3-6 Bulan',
                ],
                'specs' => [2, 1, 6],
                'type' => 'komersial',
                'portfolios' => [
                    ['title' => 'Senopati Office Tower Lobby', 'description' => 'Redesain lobby kantor 25 lantai dengan biophilic design dan vertical garden.'],
                    ['title' => 'WeWork Inspired Co-Space', 'description' => 'Co-working space 800m2 dengan zona kolaborasi dan phone booth.'],
                    ['title' => 'Tech Startup HQ', 'description' => 'Kantor pusat startup teknologi dengan open floor plan dan game room.'],
                    ['title' => 'Executive Boardroom Suite', 'description' => 'Ruang rapat eksekutif dengan smart display wall dan akustik premium.'],
                    ['title' => 'Creative Agency Office', 'description' => 'Kantor agensi kreatif dengan studio foto, ruang brainstorm, dan pantry bar.'],
                    ['title' => 'Flexible Workspace Hub', 'description' => 'Workspace hybrid dengan hot desk, private pod, dan meeting room modular.'],
                ],
            ],
            [
                'user' => [
                    'name' => 'Masamichi Katayama',
                    'email' => 'masamichi@ruangtemu.com',
                    'email_verified_at' => now(),
                    'password' => Hash::make('password'),
                    'role' => 'architect',
                    'is_active' => true,
                    'is_premium' => true,
                    'is_subscription_active' => true,
                    'premium_expires_at' => now()->addYear(),
                ],
                'profile' => [
                    'specialization' => 'Retail & Hospitality Experience',
                    'project_types' => ['Komersial', 'F&B', 'Retail Store'],
                    'price_per_m2' => 400000,
                    'rating' => 4.9,
                    'location' => 'Jakarta Pusat',
                    'style' => 'Japanese Experiential',
                    'timeline' => '2-5 Bulan',
                ],
                'specs' => [2, 4, 1],
                'type' => 'komersial',
                'portfolios' => [
                    ['title' => 'Flagship Store PIK Avenue', 'description' => 'Butik fashion 400m2 dengan instalasi seni kinetik di entrance.'],
                    ['title' => 'Omakase Counter Kemang', 'description' => 'Restoran omakase 16 seat dengan material hinoki cypress dan lighting dramatis.'],
                    ['title' => 'Concept Store Sudirman', 'description' => 'Toko konsep multi-brand dengan layout yang berubah setiap musim.'],
                    ['title' => 'Artisan Bakery Interior', 'description' => 'Interior bakery artisan dengan oven display dan counter kayu oak massif.'],
                    ['title' => 'Luxury Spa Retreat', 'description' => 'Spa mewah dengan private onsen, steam room, dan relaxation lounge.'],
                    ['title' => 'Rooftop Bar & Lounge', 'description' => 'Bar rooftop dengan panorama skyline Jakarta dan cocktail bar circular.'],
                ],
            ],
            [
                'user' => [
                    'name' => 'Budi Pradono',
                    'email' => 'budi.pradono@ruangtemu.com',
                    'email_verified_at' => now(),
                    'password' => Hash::make('password'),
                    'role' => 'architect',
                    'is_active' => true,
                    'is_premium' => true,
                    'is_subscription_active' => true,
                    'premium_expires_at' => now()->addYear(),
                ],
                'profile' => [
                    'specialization' => 'Parametric & Digital Architecture',
                    'project_types' => ['Komersial', 'Cultural Space', 'Mixed-Use'],
                    'price_per_m2' => 325000,
                    'rating' => 4.8,
                    'location' => 'Surabaya',
                    'style' => 'Parametrik Digital',
                    'timeline' => '4-8 Bulan',
                ],
                'specs' => [2, 6, 1],
                'type' => 'komersial',
                'portfolios' => [
                    ['title' => 'Community Hub Surabaya', 'description' => 'Pusat komunitas dengan fasad parametrik dari panel aluminium CNC cut.'],
                    ['title' => 'Digital Art Gallery', 'description' => 'Galeri seni digital 1200m2 dengan LED wall immersive dan spatial audio.'],
                    ['title' => 'Parametric Pavilion', 'description' => 'Paviliun pameran dengan struktur 3D printed dari beton daur ulang.'],
                    ['title' => 'Interactive Museum', 'description' => 'Museum interaktif dengan sensor gerak dan projection mapping di setiap ruang.'],
                    ['title' => 'Media Facade Building', 'description' => 'Gedung komersial dengan fasad LED responsive yang berinteraksi dengan pejalan kaki.'],
                    ['title' => 'Kinetic Art Center', 'description' => 'Pusat seni kinetik dengan elemen arsitektur yang bergerak mengikuti angin.'],
                ],
            ],
            [
                'user' => [
                    'name' => 'Andi Pratomo',
                    'email' => 'andi.pratomo@ruangtemu.com',
                    'email_verified_at' => now(),
                    'password' => Hash::make('password'),
                    'role' => 'architect',
                    'is_active' => true,
                    'is_premium' => true,
                    'is_subscription_active' => true,
                    'premium_expires_at' => now()->addYear(),
                ],
                'profile' => [
                    'specialization' => 'Sustainable Commercial Design',
                    'project_types' => ['Komersial', 'Perkantoran', 'Green Building'],
                    'price_per_m2' => 250000,
                    'rating' => 4.7,
                    'location' => 'Yogyakarta',
                    'style' => 'Green Contemporary',
                    'timeline' => '3-6 Bulan',
                ],
                'specs' => [2, 3, 5],
                'type' => 'komersial',
                'portfolios' => [
                    ['title' => 'Green Office Jogja', 'description' => 'Kantor hijau 3 lantai dengan sertifikasi Green Building dan panel surya.'],
                    ['title' => 'Malioboro Retail Complex', 'description' => 'Renovasi komplek ritel heritage di Malioboro dengan adaptive reuse.'],
                    ['title' => 'Bamboo Market Hall', 'description' => 'Pasar modern dengan struktur bambu bentang lebar tanpa kolom di tengah.'],
                    ['title' => 'Eco Hotel Prambanan', 'description' => 'Hotel ramah lingkungan 40 kamar dengan zero waste management system.'],
                    ['title' => 'Solar Canopy Mall', 'description' => 'Pusat perbelanjaan outdoor dengan kanopi panel surya yang menghasilkan listrik.'],
                    ['title' => 'Vertical Farm Market', 'description' => 'Pasar dengan vertical farming terintegrasi, sayuran dipanen langsung di tempat.'],
                ],
            ],
            [
                'user' => [
                    'name' => 'Snøhetta',
                    'email' => 'snohetta@ruangtemu.com',
                    'email_verified_at' => now(),
                    'password' => Hash::make('password'),
                    'role' => 'architect',
                    'is_active' => true,
                    'is_premium' => true,
                    'is_subscription_active' => true,
                    'premium_expires_at' => now()->addYear(),
                ],
                'profile' => [
                    'specialization' => 'Landscape-Integrated Commercial',
                    'project_types' => ['Komersial', 'Hospitality', 'Cultural Space'],
                    'price_per_m2' => 550000,
                    'rating' => 5.0,
                    'location' => 'Bali',
                    'style' => 'Scandinavian Landscape',
                    'timeline' => '6-12 Bulan',
                ],
                'specs' => [2, 3, 4],
                'type' => 'komersial',
                'portfolios' => [
                    ['title' => 'Underwater Restaurant Bali', 'description' => 'Restoran bawah laut pertama di Indonesia. Dinding kaca akrilik 360°.'],
                    ['title' => 'Mountain Library Kintamani', 'description' => 'Perpustakaan publik di kaki Gunung Batur dengan roof garden terbuka.'],
                    ['title' => 'Beachfront Resort Nusa Dua', 'description' => 'Resort butik 30 kamar yang tenggelam ke dalam kontur pantai.'],
                    ['title' => 'Volcanic Spa Center', 'description' => 'Spa center yang memanfaatkan panas bumi vulkanik untuk kolam terapi.'],
                    ['title' => 'Cliff Edge Restaurant', 'description' => 'Restoran di tepi tebing dengan lantai kaca transparan dan sunset view.'],
                    ['title' => 'Coral Reef Observatory', 'description' => 'Observatorium terumbu karang dengan tunnel bawah air dan amphitheater.'],
                ],
            ],
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

            // Create portfolios with local images
            $img = $data['type'] === 'hunian' ? $homeImg : $officeImg;
            foreach ($data['portfolios'] as $portData) {
                Portfolio::create([
                    'architect_profile_id' => $profile->id,
                    'title' => $portData['title'],
                    'description' => $portData['description'],
                    'image' => $img,
                ]);
            }

            $architects[] = $user;
        }

        // 5. PROJECTS AND REVIEWS
        $projectMockData = [
            [
                'client' => $clientTanya,
                'architect' => $architects[0], // Andra Matin
                'property_type' => 'Rumah Hunian',
                'area_size' => 200,
                'units' => 1,
                'status' => 'completed',
                'rating' => 5,
                'comment' => 'Desain Andra Matin sangat mengesankan! Memahami visi saya dengan cepat dan eksekusinya sempurna. Rumah terasa lega dan sirkulasi udaranya luar biasa.',
            ],
            [
                'client' => $clientRina,
                'architect' => $architects[4], // Achmad Tardiyana
                'property_type' => 'Rumah Hunian',
                'area_size' => 60,
                'units' => 1,
                'status' => 'completed',
                'rating' => 4,
                'comment' => 'Sangat solutif untuk rumah compact kami. Smart home integrationnya keren!',
            ],
            [
                'client' => $clientBudi,
                'architect' => $architects[6], // Masamichi Katayama
                'property_type' => 'Komersial',
                'area_size' => 150,
                'units' => 1,
                'status' => 'completed',
                'rating' => 5,
                'comment' => 'Super kreatif! Restoran kami jadi paling hits. Customer experience luar biasa.',
            ],
            [
                'client' => $clientTanya,
                'architect' => $architects[5], // Danny Wicaksono
                'property_type' => 'Komersial',
                'area_size' => 300,
                'units' => 1,
                'status' => 'paid',
                'rating' => null,
                'comment' => null,
            ],
            [
                'client' => $clientRina,
                'architect' => $architects[1], // Kengo Kuma
                'property_type' => 'Rumah Hunian',
                'area_size' => 180,
                'units' => 1,
                'status' => 'on_progress',
                'rating' => null,
                'comment' => null,
            ],
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
            'content' => 'Halo, saya ada lahan 6x12 memanjang ke belakang, ingin bangun rumah 2 lantai minimalis, bujet desain 25 juta cukup?',
            'status' => 'answered',
            'architect_id' => $architects[4]->id,
            'claimed_at' => now()->subDays(2),
            'answered_at' => now()->subDay(),
        ]);

        Answer::create([
            'question_id' => $q1->id,
            'architect_id' => $architects[4]->id,
            'content' => 'Halo Pak Michael! Untuk lahan 6x12 dengan 2 lantai, bujet 25 juta sangat reasonable untuk jasa desain lengkap. Kalau mau tambah 3D, biasanya extra 5-8 juta. Mari konsultasi lebih lanjut!',
        ]);

        Question::create([
            'client_id' => $clientRina->id,
            'content' => 'Arsitek di Jakarta Selatan ada yang bisa renovasi ruko jadi klinik kecantikan? Budget 500 jutaan.',
            'status' => 'claimed',
            'architect_id' => $architects[5]->id,
            'claimed_at' => now()->subHours(2),
        ]);

        Question::create([
            'client_id' => $clientBudi->id,
            'content' => 'Mau buka cafe industrial di Surabaya, lahan 200m2. Ada rekomendasi arsitek F&B?',
            'status' => 'open',
        ]);

        // 7. FOLLOWS
        $clientTanya->followingArchitects()->attach($architects[0]->id);
        $clientTanya->followingArchitects()->attach($architects[1]->id);
        $clientRina->followingArchitects()->attach($architects[6]->id);
        $clientBudi->followingArchitects()->attach($architects[7]->id);
    }
}
