<div class="w-full max-w-5xl mx-auto px-6">
    <div class="pt-8 pb-4">
        <div id="feature-carousel" class="carousel-track">

            <div class="ghost-circle"></div>

            <button type="button" class="feature-item" data-feature="pricing" aria-label="Pricing">
                <div class="feature-circle">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </button>

            <button type="button" class="feature-item" data-feature="profil" aria-label="Profil Arsitek">
                <div class="feature-circle">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
            </button>

            <button type="button" class="feature-item" data-feature="cari" aria-label="Cari Arsitek">
                <div class="feature-circle">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </button>

            <div class="ghost-circle"></div>

        </div>
    </div>

    <div class="text-center pt-4 pb-10">
        <h1 id="feature-title" class="text-4xl sm:text-5xl font-extrabold tracking-tight text-gray-900">
            Profil Arsitek
        </h1>
        <p id="feature-desc" class="mt-4 text-xs sm:text-sm text-gray-400 max-w-2xl mx-auto">
            Penjelasan Features: Portofolio, spesialisasi, harga per m2, Rating Arsitek
        </p>

        <!-- <div class="mt-12 flex flex-col items-center gap-3">
            <a
                id="feature-primary"
                href="{{ route('features.followed') }}"
                class="inline-flex items-center justify-center gap-4 rounded-full bg-black text-white p-1 pr-6 text-sm font-medium hover:bg-gray-800 transition w-64 max-w-full shadow-lg"
            >
                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white text-black shrink-0">
                    <svg class="w-4 h-4 ml-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <line x1="22" y1="2" x2="11" y2="13" stroke-width="2" stroke-linecap="round"/>
                        <polygon points="22 2 15 22 11 13 2 9 22 2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
                Get Started
            </a> -->

        <a href="{{ route('features.followed') }}"
            class="inline-flex items-center gap-3 bg-black text-white text-sm font-medium px-6 py-3 rounded-full hover:bg-gray-800 transition-colors">
            <span class="w-7 h-7 rounded-full border-2 border-white flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="22" y1="2" x2="11" y2="13"></line>
                    <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                </svg>
            </span>
            Get Started
        </a>

        <a href="{{ route('contact') }}"
            class="inline-flex items-center gap-2 bg-black text-white text-sm font-medium px-5 py-2 rounded-full hover:bg-gray-800 transition-colors">
            <span class="w-6 h-6 rounded-full border-2 border-white flex items-center justify-center">
                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
            </span>
            Alur Pemesanan
        </a>
        <!-- <a
                id="feature-secondary"
                href="{{ route('contact') }}"
                class="inline-flex items-center gap-3 rounded-full bg-black text-white p-1 pl-4 pr-6 text-[10px] font-medium hover:bg-gray-800 transition w-auto max-w-full shadow-md"
            >
                <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-white text-black shrink-0">
                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                </span>
                Alur Pemesanan
            </a> -->
    </div>
</div>
</div>

<script>
    (function () {
        const track = document.getElementById('feature-carousel');
        const titleEl = document.getElementById('feature-title');
        const descEl = document.getElementById('feature-desc');
        const primaryEl = document.getElementById('feature-primary');

        const features = {
            cari: {
                title: 'Cari Arsitek',
                desc: 'Penjelasan Features: Cari Arsitek sesuai Budget, Type Proyek, (hunian/Restaurant), Lokasi, Style',
                href: @json(route('features.cari')),
            },
            profil: {
                title: 'Profil Arsitek',
                desc: 'Penjelasan Features: Portofolio, spesialisasi, harga per m2, Rating Arsitek',
                href: @json(route('features.followed')),
            },
            pricing: {
                title: 'Pricing',
                desc: 'Penjelasan Features: Terdapat simulasi harga, Harga per m2, commercial, hunian, restauran, Bundle package dll',
                href: @json(route('features.pricing')),
            },
        };

        let order = ['pricing', 'profil', 'cari'];

        function renderOrder() {
            const ghosts = Array.from(track.querySelectorAll('.ghost-circle'));
            const btnMap = {};
            track.querySelectorAll('.feature-item').forEach(btn => {
                btnMap[btn.dataset.feature] = btn;
            });

            track.innerHTML = '';
            track.appendChild(ghosts[0]);

            order.forEach((id, pos) => {
                const btn = btnMap[id];
                const isCenter = pos === 1; // Index 1 selalu yang di tengah

                // Menggunakan class CSS kamu: is-active dan is-side
                btn.classList.toggle('is-active', isCenter);
                btn.classList.toggle('is-side', !isCenter);

                track.appendChild(btn);
            });

            track.appendChild(ghosts[1]);
            attachListeners();
        }

        function updateText(id) {
            const f = features[id];
            if (!f) return;
            titleEl.classList.add('fading');
            descEl.classList.add('fading');
            setTimeout(() => {
                titleEl.textContent = f.title;
                descEl.textContent = f.desc;
                primaryEl.setAttribute('href', f.href);
                titleEl.classList.remove('fading');
                descEl.classList.remove('fading');
            }, 200);
        }

        // --- INI BAGIAN YANG DIPERBAIKI ---
        function setActive(clickedId) {
            const idx = order.indexOf(clickedId);

            // Jika yang diklik sudah di tengah, abaikan
            if (idx === 1) return;

            // Jika klik item KIRI (index 0), geser array ke Kanan
            if (idx === 0) {
                order = [order[2], order[0], order[1]];
            }
            // Jika klik item KANAN (index 2), geser array ke Kiri
            else {
                order = [order[1], order[2], order[0]];
            }

            renderOrder();
            updateText(order[1]);
        }

        function attachListeners() {
            track.querySelectorAll('.feature-item').forEach(btn => {
                btn.onclick = () => setActive(btn.dataset.feature);
            });
        }

        renderOrder();
        updateText('profil');
    })();
</script>