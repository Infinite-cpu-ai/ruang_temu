<div class="w-full max-w-5xl mx-auto py-12 px-4">
    <div class="text-center mb-6">
        <h2 id="carousel-title" class="text-2xl font-semibold text-gray-800 transition-all duration-300">
            Jelajahi Ruang Temu
        </h2>
        <p class="text-gray-500 text-sm mt-1">Geser untuk melihat fitur</p>
    </div>

    <!-- Carousel Container -->
    <div 
        id="drag-carousel" 
        class="flex gap-6 overflow-x-auto no-scrollbar cursor-grab items-center px-4 py-4 snap-x snap-mandatory"
    >
        <!-- Circle 1: Dummy -->
        <div class="shrink-0 w-32 h-32 md:w-48 md:h-48 rounded-full border-4 border-dashed border-gray-200 flex items-center justify-center opacity-50 snap-center select-none"
             onmouseenter="updateCarouselTitle('')"
             onmouseleave="updateCarouselTitle('Jelajahi Ruang Temu')">
            <span class="text-gray-400 text-sm">Awal</span>
        </div>

        <!-- Circle 2: Search -->
        <a href="{{ route('features.cari') }}" draggable="false" class="shrink-0 w-40 h-40 md:w-56 md:h-56 rounded-full bg-blue-50 border border-blue-100 flex flex-col items-center justify-center shadow-sm hover:shadow-md hover:scale-105 transition-transform duration-300 snap-center select-none"
           onmouseenter="updateCarouselTitle('Cari Arsitek Favoritmu')"
           onmouseleave="updateCarouselTitle('Jelajahi Ruang Temu')">
            <svg class="w-10 h-10 text-blue-500 mb-2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            <span class="font-medium text-blue-800 pointer-events-none">Cari Arsitek</span>
        </a>

        <!-- Circle 3: Profile (Active/Center) -->
        <a href="{{ route('features.profil', 1) }}" draggable="false" class="shrink-0 w-48 h-48 md:w-64 md:h-64 rounded-full bg-indigo-600 flex flex-col items-center justify-center shadow-xl hover:scale-105 transition-transform duration-300 snap-center select-none"
           onmouseenter="updateCarouselTitle('Lihat Profil & Portofolio')"
           onmouseleave="updateCarouselTitle('Jelajahi Ruang Temu')">
            <svg class="w-12 h-12 text-white mb-2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            <span class="font-bold text-white pointer-events-none">Profil Arsitek</span>
        </a>

        <!-- Circle 4: Pricing -->
        <a href="{{ route('features.pricing') }}" draggable="false" class="shrink-0 w-40 h-40 md:w-56 md:h-56 rounded-full bg-emerald-50 border border-emerald-100 flex flex-col items-center justify-center shadow-sm hover:shadow-md hover:scale-105 transition-transform duration-300 snap-center select-none"
           onmouseenter="updateCarouselTitle('Hitung Estimasi Biaya')"
           onmouseleave="updateCarouselTitle('Jelajahi Ruang Temu')">
            <svg class="w-10 h-10 text-emerald-500 mb-2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="font-medium text-emerald-800 pointer-events-none">Pricing</span>
        </a>

        <!-- Circle 5: Dummy -->
        <div class="shrink-0 w-32 h-32 md:w-48 md:h-48 rounded-full border-4 border-dashed border-gray-200 flex items-center justify-center opacity-50 snap-center select-none"
             onmouseenter="updateCarouselTitle('')"
             onmouseleave="updateCarouselTitle('Jelajahi Ruang Temu')">
            <span class="text-gray-400 text-sm">Akhir</span>
        </div>
    </div>
</div>

<script>
    const carouselTitle = document.getElementById('carousel-title');
    function updateCarouselTitle(text) {
        if(text === '') text = 'Jelajahi Ruang Temu';
        carouselTitle.innerText = text;
    }

    const slider = document.getElementById('drag-carousel');
    let isDown = false;
    let startX;
    let scrollLeft;
    let isDragging = false; // Flag to prevent click event if scrolling occurred

    slider.addEventListener('mousedown', (e) => {
        isDown = true;
        isDragging = false;
        slider.classList.add('cursor-grabbing');
        slider.classList.remove('cursor-grab');
        slider.classList.remove('snap-mandatory'); // Smooth out manual drag
        
        startX = e.pageX - slider.offsetLeft;
        scrollLeft = slider.scrollLeft;
    });

    slider.addEventListener('mouseleave', () => {
        isDown = false;
        slider.classList.remove('cursor-grabbing');
        slider.classList.add('cursor-grab');
        slider.classList.add('snap-mandatory');
    });

    slider.addEventListener('mouseup', () => {
        isDown = false;
        slider.classList.remove('cursor-grabbing');
        slider.classList.add('cursor-grab');
        slider.classList.add('snap-mandatory');
    });

    slider.addEventListener('mousemove', (e) => {
        if (!isDown) return;
        e.preventDefault();
        
        const x = e.pageX - slider.offsetLeft;
        const walk = (x - startX) * 2; // Scroll-fast multiplier
        
        if (Math.abs(walk) > 5) {
            isDragging = true; // Mark as dragging if moved more than 5px
        }
        
        slider.scrollLeft = scrollLeft - walk;
    });

    // Prevent links from navigating if the user was just trying to drag
    slider.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', (e) => {
            if (isDragging) {
                e.preventDefault();
            }
        });
    });

    // Initialize position to the middle element (Circle 3)
    window.addEventListener('load', () => {
        const centerElement = slider.children[2]; // Profile Circle
        const scrollPosition = centerElement.offsetLeft - (slider.offsetWidth / 2) + (centerElement.offsetWidth / 2);
        slider.scrollLeft = scrollPosition;
    });
</script>