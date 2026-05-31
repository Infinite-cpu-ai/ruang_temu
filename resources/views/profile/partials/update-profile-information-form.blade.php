<section>
    <div class="mb-6">
        <h2 class="text-base font-extrabold text-gray-900">Informasi Profil</h2>
        <p class="mt-1 text-sm text-gray-400 font-medium">Perbarui nama, foto, dan alamat email akun kamu.</p>
    </div>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-5" enctype="multipart/form-data"
          x-data="{ photoName: null, photoPreview: null }">
        @csrf
        @method('patch')

        {{-- Avatar Upload --}}
        <div class="flex items-center gap-5">
            <div class="relative group">
                {{-- Current / Preview --}}
                <div class="w-20 h-20 rounded-full overflow-hidden border-2 border-white shadow-md bg-gray-200" x-show="!photoPreview">
                    <img src="{{ $user->profile_image_url }}"
                         alt="{{ $user->name }}" class="w-full h-full object-cover" />
                </div>
                <div class="w-20 h-20 rounded-full overflow-hidden border-2 border-white shadow-md bg-cover bg-center bg-no-repeat"
                     x-show="photoPreview" style="display:none;"
                     x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                </div>
            </div>
            <div>
                <input type="file" id="profile_image" name="profile_image" class="hidden"
                       x-ref="photo"
                       x-on:change="
                           photoName = $refs.photo.files[0].name;
                           const reader = new FileReader();
                           reader.onload = (e) => { photoPreview = e.target.result; };
                           reader.readAsDataURL($refs.photo.files[0]);
                       " />
                <button type="button"
                        x-on:click.prevent="$refs.photo.click()"
                        class="inline-flex items-center gap-2 rounded-xl border border-gray-200 bg-white px-4 py-2 text-xs font-bold text-gray-700 hover:bg-gray-50 transition shadow-sm">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Ganti Foto
                </button>
                <p class="mt-1 text-[11px] text-gray-400 font-medium" x-text="photoName ? photoName : 'JPG, PNG, max 2MB'"></p>
                @error('profile_image')
                    <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Name --}}
        <div>
            <label for="name" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Nama</label>
            <input id="name" name="name" type="text"
                   value="{{ old('name', $user->name) }}"
                   required autofocus autocomplete="name"
                   class="w-full bg-gray-50 border-0 rounded-2xl py-3 px-4 text-sm text-gray-800 font-medium focus:ring-2 focus:ring-black transition shadow-sm placeholder-gray-300" />
            @error('name')
                <p class="mt-1.5 text-xs text-red-500 font-medium">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div>
            <label for="email" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Email</label>
            <input id="email" name="email" type="email"
                   value="{{ old('email', $user->email) }}"
                   required autocomplete="username"
                   class="w-full bg-gray-50 border-0 rounded-2xl py-3 px-4 text-sm text-gray-800 font-medium focus:ring-2 focus:ring-black transition shadow-sm" />
            @error('email')
                <p class="mt-1.5 text-xs text-red-500 font-medium">{{ $message }}</p>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3 p-3 rounded-xl bg-amber-50 border border-amber-100">
                    <p class="text-xs text-amber-700 font-medium">
                        Email belum diverifikasi.
                        <button form="send-verification" class="underline font-bold hover:text-amber-900 transition">
                            Kirim ulang email verifikasi.
                        </button>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-1 text-xs text-emerald-600 font-semibold">Link verifikasi telah dikirim!</p>
                    @endif
                </div>
            @endif
        </div>

        {{-- Save --}}
        <div class="flex items-center gap-4 pt-1">
            <button type="submit"
                    class="inline-flex items-center gap-2 rounded-2xl bg-gray-900 px-6 py-3 text-sm font-bold text-white hover:bg-black transition active:scale-[0.97] shadow-sm">
                Simpan Perubahan
            </button>
            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition
                   x-init="setTimeout(() => show = false, 2500)"
                   class="text-sm font-semibold text-emerald-600 flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                    Tersimpan!
                </p>
            @endif
        </div>
    </form>
</section>
