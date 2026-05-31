@extends('layouts.landing')

@section('content')

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:wght@300;400;500;600&display=swap');

        .portfolio-edit * {
            font-family: 'DM Sans', sans-serif;
        }

        .portfolio-edit h1,
        .portfolio-edit h2,
        .portfolio-edit h3 {
            font-family: 'Syne', sans-serif;
        }

        .portfolio-edit {
            background: #f5f4f0;
            min-height: 100vh;
        }

        /* ── Header ── */
        .page-header {
            background: #0f0f0f;
            padding: 1.75rem 0;
        }

        .page-header-inner {
            max-width: 780px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .back-btn {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            background: #1e1e1e;
            border: 1px solid #2e2e2e;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #888;
            text-decoration: none;
            transition: all 0.15s;
            flex-shrink: 0;
        }

        .back-btn:hover {
            background: #2a2a2a;
            color: #fff;
        }

        .page-header-text h1 {
            color: #fff;
            font-size: 1.25rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            margin: 0;
        }

        .page-header-text p {
            color: #555;
            font-size: 0.8rem;
            margin: 0.15rem 0 0;
        }

        /* ── Body ── */
        .page-body {
            max-width: 780px;
            margin: 0 auto;
            padding: 2rem 2rem 4rem;
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
        }

        /* ── Card ── */
        .card {
            background: #fff;
            border-radius: 20px;
            border: 1px solid #e8e6e0;
            overflow: hidden;
        }

        .card-header {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #f0ede8;
            display: flex;
            align-items: center;
            gap: 0.65rem;
        }

        .card-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #0f0f0f;
            flex-shrink: 0;
        }

        .card-header h3 {
            font-size: 0.88rem;
            font-weight: 700;
            color: #0f0f0f;
            margin: 0;
            letter-spacing: -0.01em;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* ── Field ── */
        .field-group {
            display: flex;
            flex-direction: column;
            gap: 0.4rem;
            margin-bottom: 1.25rem;
        }

        .field-group:last-child {
            margin-bottom: 0;
        }

        .field-label {
            font-size: 0.73rem;
            font-weight: 600;
            color: #888;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .field-input,
        .field-textarea {
            padding: 0.75rem 1rem;
            border-radius: 12px;
            border: 1.5px solid #e8e6e0;
            font-size: 0.88rem;
            color: #0f0f0f;
            background: #fafaf8;
            outline: none;
            font-family: 'DM Sans', sans-serif;
            width: 100%;
            box-sizing: border-box;
            transition: border-color 0.15s, box-shadow 0.15s, background 0.15s;
        }

        .field-input:focus,
        .field-textarea:focus {
            border-color: #0f0f0f;
            box-shadow: 0 0 0 3px rgba(15, 15, 15, 0.06);
            background: #fff;
        }

        .field-input::placeholder,
        .field-textarea::placeholder {
            color: #ccc;
        }

        .field-textarea {
            resize: vertical;
            min-height: 130px;
            line-height: 1.6;
        }

        /* ── Image Preview ── */
        .image-preview-wrap {
            border-radius: 14px;
            overflow: hidden;
            border: 1.5px solid #e8e6e0;
            background: #f5f4f0;
            margin-bottom: 1.25rem;
            position: relative;
        }

        .image-preview-wrap img {
            width: 100%;
            max-height: 260px;
            object-fit: cover;
            display: block;
        }

        .image-preview-badge {
            position: absolute;
            top: 0.75rem;
            left: 0.75rem;
            background: rgba(15, 15, 15, 0.65);
            color: #fff;
            font-size: 0.7rem;
            font-weight: 600;
            padding: 0.3rem 0.7rem;
            border-radius: 50px;
            backdrop-filter: blur(6px);
            letter-spacing: 0.03em;
        }

        /* ── File Upload ── */
        .upload-zone {
            border: 1.5px dashed #d8d5cf;
            border-radius: 14px;
            background: #fafaf8;
            padding: 1.25rem 1rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            cursor: pointer;
            transition: border-color 0.15s, background 0.15s;
        }

        .upload-zone:hover {
            border-color: #0f0f0f;
            background: #f5f4f0;
        }

        .upload-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: #f0ede8;
            border: 1px solid #e0ddd8;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #888;
            flex-shrink: 0;
        }

        .upload-text p {
            margin: 0;
            font-size: 0.83rem;
            font-weight: 600;
            color: #0f0f0f;
        }

        .upload-text span {
            font-size: 0.75rem;
            color: #aaa;
            font-weight: 400;
        }

        input[type="file"].hidden-file {
            display: none;
        }

        .error-msg {
            font-size: 0.75rem;
            color: #ef4444;
            margin-top: 0.3rem;
            font-weight: 500;
        }

        /* ── Footer ── */
        .card-footer {
            padding: 1.25rem 1.5rem;
            border-top: 1px solid #f0ede8;
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 0.75rem;
        }

        .btn-cancel {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.65rem 1.25rem;
            border-radius: 50px;
            font-size: 0.83rem;
            font-weight: 600;
            color: #666;
            background: #f0ede8;
            border: none;
            text-decoration: none;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
            transition: background 0.15s, color 0.15s;
        }

        .btn-cancel:hover {
            background: #e5e2dc;
            color: #0f0f0f;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.7rem 1.5rem;
            background: #0f0f0f;
            color: #fff;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 700;
            border: none;
            cursor: pointer;
            font-family: 'Syne', sans-serif;
            letter-spacing: -0.01em;
            transition: all 0.15s;
        }

        .btn-primary:hover {
            background: #2a2a2a;
            transform: translateY(-1px);
        }

        .btn-primary:active {
            transform: translateY(0);
        }
    </style>

    <div class="portfolio-edit">

        <!-- Header -->
        <div class="page-header">
            <div class="page-header-inner">
                <a href="{{ route('architect.portfolios.index') }}" class="back-btn" title="Kembali">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div class="page-header-text">
                    <h1>Edit Portofolio</h1>
                    <p>Perbarui detail dan gambar proyek Anda</p>
                </div>
            </div>
        </div>

        <!-- Body -->
        <div class="page-body">

            <form action="{{ route('architect.portfolios.update', $portfolio) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Judul -->
                <div class="card">
                    <div class="card-header">
                        <div class="card-dot"></div>
                        <h3>Informasi Proyek</h3>
                    </div>
                    <div class="card-body">
                        <div class="field-group">
                            <label class="field-label" for="title">Judul Proyek</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $portfolio->title) }}"
                                required class="field-input" placeholder="Contoh: Rumah Tropis Modern — Jakarta Selatan">
                            @error('title')
                                <p class="error-msg">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="field-group">
                            <label class="field-label" for="description">Deskripsi Proyek</label>
                            <textarea name="description" id="description" class="field-textarea"
                                placeholder="Ceritakan tentang proyek ini — konsep, tantangan, dan hasil yang dicapai...">{{ old('description', $portfolio->description) }}</textarea>
                            @error('description')
                                <p class="error-msg">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Gambar -->
                <div class="card">
                    <div class="card-header">
                        <div class="card-dot"></div>
                        <h3>Gambar Portofolio</h3>
                    </div>
                    <div class="card-body">

                        <!-- Preview gambar saat ini -->
                        <div class="image-preview-wrap">
                            <img src="{{ $portfolio->image_url }}" alt="Gambar saat ini">
                            <span class="image-preview-badge">Gambar saat ini</span>
                        </div>

                        <!-- Upload ganti gambar -->
                        <div class="field-group">
                            <label class="field-label">Ganti Gambar <span
                                    style="font-size:0.7rem;color:#aaa;text-transform:none;letter-spacing:0;">(opsional)</span></label>
                            <div class="upload-zone" onclick="document.getElementById('image-input').click()">
                                <div class="upload-icon">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div class="upload-text">
                                    <p id="upload-label">Klik untuk pilih gambar baru</p>
                                    <span>JPG, PNG, WEBP — maks. 2MB</span>
                                </div>
                            </div>
                            <input type="file" name="image" id="image-input" class="hidden-file" accept="image/*"
                                onchange="document.getElementById('upload-label').textContent = this.files[0]?.name || 'Klik untuk pilih gambar baru'">
                            @error('image')
                                <p class="error-msg">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    <div class="card-footer">
                        <a href="{{ route('architect.portfolios.index') }}" class="btn-cancel">
                            Batal
                        </a>
                        <button type="submit" class="btn-primary">
                            Simpan Perubahan
                            <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>
                </div>

            </form>

        </div>
    </div>

@endsection