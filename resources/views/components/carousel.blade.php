<div class="w-full max-w-5xl mx-auto px-6">
    <div class="pt-8 pb-4">
        <div
            id="feature-carousel"
            class="flex items-center justify-center gap-10 overflow-x-auto no-scrollbar cursor-grab select-none snap-x snap-mandatory px-6 py-6"
        >
            <div class="feature-spacer shrink-0 w-24 snap-center" aria-hidden="true"></div>

            <button
                type="button"
                class="feature-item shrink-0 snap-center"
                data-feature="pricing"
                aria-label="Pricing"
            >
                <div class="feature-circle w-14 h-14 rounded-full border border-gray-200 bg-white flex items-center justify-center text-gray-700 transition-transform duration-200 scale-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </button>

            <button
                type="button"
                class="feature-item shrink-0 snap-center"
                data-feature="profil"
                aria-label="Profil Arsitek"
            >
                <div class="feature-circle w-14 h-14 rounded-full border border-gray-200 bg-white flex items-center justify-center text-gray-700 transition-transform duration-200 scale-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
            </button>

            <button
                type="button"
                class="feature-item shrink-0 snap-center"
                data-feature="cari"
                aria-label="Cari Arsitek"
            >
                <div class="feature-circle w-14 h-14 rounded-full border border-gray-200 bg-white flex items-center justify-center text-gray-700 transition-transform duration-200 scale-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </button>

            <div class="feature-spacer shrink-0 w-24 snap-center" aria-hidden="true"></div>
        </div>
    </div>

    <div class="text-center pt-4 pb-10">
        <h1 id="feature-title" class="text-4xl sm:text-5xl font-extrabold tracking-tight text-gray-900">
            Profil Arsitek
        </h1>
        <p id="feature-desc" class="mt-4 text-xs sm:text-sm text-gray-300 max-w-2xl mx-auto">
            Penjelasan Features: Portofolio, spesialisasi, harga per m2, Rating Arsitek
        </p>

        <div class="mt-12 flex flex-col items-center gap-3">
            <a
                id="feature-primary"
                href="{{ route('features.profil', 1) }}"
                class="inline-flex items-center justify-center gap-3 rounded-full bg-black text-white px-12 py-3 text-sm font-medium shadow-sm hover:bg-gray-900 transition w-72 max-w-full"
            >
                <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-white/10">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M22 2L11 13"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M22 2l-7 20-4-9-9-4 20-7z"></path>
                    </svg>
                </span>
                Get Started
            </a>

            <a
                id="feature-secondary"
                href="{{ route('contact') }}"
                class="inline-flex items-center justify-center gap-3 rounded-full bg-black text-white/90 px-10 py-2.5 text-[11px] font-medium shadow-sm hover:bg-gray-900 transition w-56 max-w-full"
            >
                <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-white/10">
                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5a3 3 0 006 0"></path>
                    </svg>
                </span>
                Alur Pemesanan
            </a>
        </div>
    </div>
</div>

<script>
    (function () {
        const slider = document.getElementById('feature-carousel');
        const items = Array.from(slider.querySelectorAll('.feature-item'));
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
                href: @json(route('features.profil', 1)),
            },
            pricing: {
                title: 'Pricing',
                desc: 'Penjelasan Features: Terdapat simulasi harga, Harga per m2, commercial, hunian, restauran, Bundle package dll',
                href: @json(route('features.pricing')),
            },
        };

        let isDown = false;
        let startX = 0;
        let scrollLeft = 0;
        let isDragging = false;
        let raf = null;
        let activeId = null;

        function setActive(id) {
            if (!features[id] || activeId === id) return;
            activeId = id;

            const f = features[id];
            titleEl.textContent = f.title;
            descEl.textContent = f.desc;
            primaryEl.setAttribute('href', f.href);

            items.forEach((btn) => {
                const circle = btn.querySelector('.feature-circle');
                const isActive = btn.dataset.feature === id;

                btn.setAttribute('aria-current', isActive ? 'true' : 'false');

                circle.classList.toggle('scale-125', isActive);
                circle.classList.toggle('scale-100', !isActive);
                circle.classList.toggle('shadow-lg', isActive);
                circle.classList.toggle('border-gray-300', isActive);
                circle.classList.toggle('text-gray-900', isActive);
                circle.classList.toggle('text-gray-700', !isActive);
            });
        }

        function syncSpacers() {
            const spacers = Array.from(slider.querySelectorAll('.feature-spacer'));
            if (spacers.length !== 2) return;
            const sample = items[0]?.querySelector('.feature-circle');
            const sampleWidth = sample ? sample.getBoundingClientRect().width : 56;
            const width = Math.max(0, (slider.clientWidth / 2) - (sampleWidth / 2));
            spacers.forEach((s) => {
                s.style.width = width + 'px';
            });
        }

        function findClosestToCenter() {
            const centerX = slider.scrollLeft + slider.clientWidth / 2;
            let closest = null;
            let closestDist = Infinity;

            items.forEach((btn) => {
                const rectLeft = btn.offsetLeft;
                const width = btn.offsetWidth;
                const itemCenter = rectLeft + width / 2;
                const dist = Math.abs(itemCenter - centerX);

                if (dist < closestDist) {
                    closestDist = dist;
                    closest = btn;
                }
            });

            if (closest) {
                setActive(closest.dataset.feature);
            }
        }

        function scheduleCenterCheck() {
            if (raf) return;
            raf = requestAnimationFrame(() => {
                raf = null;
                findClosestToCenter();
            });
        }

        slider.addEventListener('scroll', scheduleCenterCheck, { passive: true });

        slider.addEventListener('mousedown', (e) => {
            isDown = true;
            isDragging = false;
            slider.classList.add('cursor-grabbing');
            slider.classList.remove('cursor-grab');
            slider.classList.remove('snap-mandatory');
            startX = e.pageX - slider.offsetLeft;
            scrollLeft = slider.scrollLeft;
        });

        slider.addEventListener('mouseleave', () => {
            isDown = false;
            slider.classList.remove('cursor-grabbing');
            slider.classList.add('cursor-grab');
            slider.classList.add('snap-mandatory');
        });

        window.addEventListener('mouseup', () => {
            isDown = false;
            slider.classList.remove('cursor-grabbing');
            slider.classList.add('cursor-grab');
            slider.classList.add('snap-mandatory');
        });

        slider.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - slider.offsetLeft;
            const walk = (x - startX) * 1.8;
            if (Math.abs(walk) > 5) {
                isDragging = true;
            }
            slider.scrollLeft = scrollLeft - walk;
        });

        items.forEach((btn) => {
            btn.addEventListener('click', () => {
                if (isDragging) return;
                const target = btn;
                const scrollTo = target.offsetLeft - (slider.clientWidth / 2) + (target.offsetWidth / 2);
                slider.scrollTo({ left: scrollTo, behavior: 'smooth' });
                setActive(target.dataset.feature);
            });
        });

        window.addEventListener('load', () => {
            syncSpacers();
            const defaultBtn = items.find((b) => b.dataset.feature === 'profil') || items[0];
            const scrollTo = defaultBtn.offsetLeft - (slider.clientWidth / 2) + (defaultBtn.offsetWidth / 2);
            slider.scrollLeft = scrollTo;
            setActive(defaultBtn.dataset.feature);
        });

        window.addEventListener('resize', () => {
            syncSpacers();
            scheduleCenterCheck();
        });
    })();
</script>