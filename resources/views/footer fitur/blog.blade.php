@extends('layouts.app')

@section('title', 'Blog & Informasi - DelShoope')

@section('content')
@php
$posts = [
[
'title' => 'Sneakers Guide: Cara Pilih Sepatu yang Nyaman & Awet',
'slug' => 'sneakers-guide-cara-pilih-sepatu',
'category' => 'Fashion',
'excerpt' => 'Checklist sebelum checkout: material, ukuran, insole, dan pemakaian. Biar gak jadi pajangan lemari.',
'date' => '2025-12-18',
'read' => 6,
'author' => 'DelShoope Team',
'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=1400&q=80',
'tags' => ['shoes', 'sneakers', 'guide'],
'featured' => true,
],
[
'title' => 'Kopi: Bedakan Arabica vs Robusta Biar Gak Salah Beli',
'slug' => 'kopi-arabica-vs-robusta',
'category' => 'Food & Drink',
'excerpt' => 'Rasa, aroma, dan kadar kafein beda. Pilih yang pas sesuai selera dan kebutuhan harian.',
'date' => '2025-12-12',
'read' => 5,
'author' => 'DelShoope Team',
'image' => 'https://images.unsplash.com/photo-1509042239860-f550ce710b93?auto=format&fit=crop&w=1400&q=80',
'tags' => ['coffee', 'beans', 'taste'],
'featured' => true,
],
[
'title' => 'Baju: Cara Cek Ukuran yang Bener di Online Shop',
'slug' => 'cara-cek-ukuran-baju-online',
'category' => 'Fashion',
'excerpt' => 'Ukuran S/M/L sering beda tiap brand. Yang penting itu cm dan cara ukur badan yang tepat.',
'date' => '2025-12-05',
'read' => 7,
'author' => 'DelShoope Team',
'image' => 'https://images.unsplash.com/photo-1520975869011-3f3b76f49d3c?auto=format&fit=crop&w=1400&q=80',
'tags' => ['shirt', 'size', 'chart'],
'featured' => false,
],
[
'title' => 'Celana: Tips Pilih Celana yang Fit dan Nyaman',
'slug' => 'tips-pilih-celana-yang-fit',
'category' => 'Fashion',
'excerpt' => 'Waist, inseam, rise, dan bahan itu kunci. Biar gak “narik” dan enak dipakai harian.',
'date' => '2025-11-28',
'read' => 4,
'author' => 'DelShoope Team',
'image' => 'https://images.unsplash.com/photo-1473966968600-fa801b869a1a?auto=format&fit=crop&w=1400&q=80',
'tags' => ['pants', 'fit', 'denim'],
'featured' => false,
],
[
'title' => 'Optimasi Checkout: 7 Hal yang Bikin User Kabur',
'slug' => 'optimasi-checkout-7-hal',
'category' => 'E-commerce',
'excerpt' => 'Form kepanjangan, ongkir misterius, dan tombol bayar yang ngumpet. Ini cara beresinnya.',
'date' => '2025-11-20',
'read' => 6,
'author' => 'DelShoope Team',
'image' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=1400&q=80',
'tags' => ['ux', 'checkout', 'conversion'],
'featured' => false,
],
[
'title' => 'SEO Produk: Setting Minimal yang Wajib Ada',
'slug' => 'seo-produk-setting-minimal',
'category' => 'SEO',
'excerpt' => 'Title, meta, alt image, dan slug. Small thing, big impact. Apalagi kalau produk lo banyak.',
'date' => '2025-11-15',
'read' => 5,
'author' => 'DelShoope Team',
'image' => 'https://images.unsplash.com/photo-1556155092-490a1ba16284?auto=format&fit=crop&w=1400&q=80',
'tags' => ['seo', 'catalog', 'discover'],
'featured' => false,
],
];

$q = request('q', '');
$cat = request('category', '');
$sort = request('sort', 'newest');

$categories = collect($posts)->pluck('category')->unique()->values()->all();

$filtered = collect($posts)->filter(function($p) use ($q, $cat){
$hay = mb_strtolower($p['title'].' '.$p['excerpt'].' '.implode(' ', $p['tags']));
$okQ = $q === '' || str_contains($hay, mb_strtolower($q));
$okC = $cat === '' || $p['category'] === $cat;
return $okQ && $okC;
});

$sorted = $filtered->sortBy(function($p) use ($sort){
return match($sort){
'oldest' => $p['date'],
'shortest' => $p['read'],
'longest' => -$p['read'],
default => -strtotime($p['date']),
};
})->values();

$perPage = 6;
$page = max((int) request('page', 1), 1);
$total = $sorted->count();
$pages = (int) ceil(max($total,1)/$perPage);
$page = min($page, $pages);
$slice = $sorted->slice(($page-1)*$perPage, $perPage)->values();

$featured = collect($posts)->where('featured', true)->take(2)->values();
@endphp

<section class="blog-page">
    <div class="blog-container">
        {{-- HERO --}}
        <div class="hero">
            <div class="hero-left">
                <div class="kicker">Blog & Informasi</div>
                <h1 class="hero-title">Update e-commerce yang beneran kepakai.</h1>
                <p class="hero-sub">
                    Produk, fashion, kopi, sampai UX checkout. Biar user makin yakin beli dan toko lo makin kredibel.
                </p>

                <div class="hero-actions">
                    <a href="{{ route('softwaredeveloper') }}" class="btn primary">Jalur Software Developer <span>→</span></a>
                    <a href="#posts" class="btn">Lihat Artikel</a>
                </div>

                <div class="stats">
                    <div class="stat">
                        <div class="stat-num">{{ count($posts) }}</div>
                        <div class="stat-label">Artikel</div>
                    </div>
                    <div class="stat">
                        <div class="stat-num">{{ count($categories) }}</div>
                        <div class="stat-label">Kategori</div>
                    </div>
                    <div class="stat">
                        <div class="stat-num">{{ $total }}</div>
                        <div class="stat-label">Hasil filter</div>
                    </div>
                </div>
            </div>

            <div class="hero-right">
                <div class="panel">
                    <div class="panel-head">
                        <div>
                            <h2>Featured</h2>
                            <p>Artikel ringkas yang sering dicari.</p>
                        </div>
                    </div>

                    <div class="featured-list">
                        @foreach($featured as $f)
                        <div class="featured-item">
                            <div class="featured-img">
                                <img src="{{ $f['image'] }}" alt="{{ $f['title'] }}" loading="lazy">
                            </div>
                            <div class="featured-info">
                                <div class="pill">{{ $f['category'] }}</div>
                                <div class="featured-title">{{ $f['title'] }}</div>
                                <div class="muted">
                                    🗓 {{ \Carbon\Carbon::parse($f['date'])->format('d M Y') }}
                                    <span class="sep">•</span>
                                    ⏱ {{ $f['read'] }} menit
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="note">
                        Halaman ini fokus “info ringkas”, jadi <b>gak perlu klik gambar</b>.
                    </div>
                </div>
            </div>
        </div>

        {{-- CONTROLS --}}
        <div class="controls" id="posts">
            <form method="GET" class="control-form">
                <div class="field">
                    <label>Cari</label>
                    <input type="text" name="q" value="{{ $q }}" placeholder="Cari: sepatu, kopi, baju, checkout...">
                </div>

                <div class="field">
                    <label>Kategori</label>
                    <select name="category">
                        <option value="">Semua</option>
                        @foreach($categories as $c)
                        <option value="{{ $c }}" {{ $cat === $c ? 'selected' : '' }}>{{ $c }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="field">
                    <label>Urutkan</label>
                    <select name="sort">
                        <option value="newest" {{ $sort==='newest'?'selected':'' }}>Terbaru</option>
                        <option value="oldest" {{ $sort==='oldest'?'selected':'' }}>Terlama</option>
                        <option value="shortest" {{ $sort==='shortest'?'selected':'' }}>Baca tercepat</option>
                        <option value="longest" {{ $sort==='longest'?'selected':'' }}>Baca terlama</option>
                    </select>
                </div>

                <div class="actions">
                    <button class="btn primary" type="submit">Terapkan</button>
                    <a class="btn" href="{{ route('blog') }}">Reset</a>
                </div>
            </form>

            <div class="chips">
                <a class="chip {{ $cat==='' ? 'active' : '' }}"
                    href="{{ route('blog', array_merge(request()->except('page'), ['category'=>''])) }}">
                    Semua
                </a>
                @foreach($categories as $c)
                <a class="chip {{ $cat===$c ? 'active' : '' }}"
                    href="{{ route('blog', array_merge(request()->except('page'), ['category'=>$c])) }}">
                    {{ $c }}
                </a>
                @endforeach
            </div>

            <div class="info">
                Menampilkan <b>{{ $slice->count() }}</b> dari <b>{{ $total }}</b> artikel
            </div>
        </div>

        {{-- POSTS GRID --}}
        <div class="grid">
            @forelse($slice as $post)
            <article class="card">
                <div class="thumb">
                    <img src="{{ $post['image'] }}" alt="{{ $post['title'] }}" loading="lazy">
                    <div class="badge">{{ $post['category'] }}</div>
                </div>

                <div class="body">
                    <div class="meta">
                        <span>🗓 {{ \Carbon\Carbon::parse($post['date'])->format('d M Y') }}</span>
                        <span class="sep">•</span>
                        <span>⏱ {{ $post['read'] }} menit</span>
                        <span class="sep">•</span>
                        <span>✍ {{ $post['author'] }}</span>
                    </div>

                    <h3 class="title">{{ $post['title'] }}</h3>
                    <p class="excerpt">{{ $post['excerpt'] }}</p>

                    <div class="tags">
                        @foreach($post['tags'] as $t)
                        <span class="tag">#{{ $t }}</span>
                        @endforeach
                    </div>

                    {{-- Optional: kalau mau tetap ada link detail, tapi bukan gambar --}}
                    <a class="readmore" href="{{ url('/blog/'.$post['slug']) }}">Lihat detail <span>→</span></a>
                </div>
            </article>
            @empty
            <div class="empty">
                Tidak ada artikel yang cocok. Query lo kemungkinan random.
            </div>
            @endforelse
        </div>

        {{-- PAGINATION --}}
        @if($pages > 1)
        <nav class="pager" aria-label="Pagination">
            @php $base = request()->except('page'); @endphp

            <a class="pagebtn {{ $page <= 1 ? 'disabled' : '' }}"
                href="{{ $page <= 1 ? '#' : url()->current().'?'.http_build_query(array_merge($base, ['page'=>$page-1])) }}">
                ← Prev
            </a>

            <div class="pagenums">
                @for($i = 1; $i <= $pages; $i++)
                    <a class="pagenum {{ $i === $page ? 'active' : '' }}"
                    href="{{ url()->current().'?'.http_build_query(array_merge($base, ['page'=>$i])) }}">
                    {{ $i }}
                    </a>
                    @endfor
            </div>

            <a class="pagebtn {{ $page >= $pages ? 'disabled' : '' }}"
                href="{{ $page >= $pages ? '#' : url()->current().'?'.http_build_query(array_merge($base, ['page'=>$page+1])) }}">
                Next →
            </a>
        </nav>
        @endif
    </div>
</section>

<style>
    /* ====== THEME (Light modern) ====== */
    .blog-page {
        --bg: #f6f7fb;
        --card: #ffffff;
        --text: #0f172a;
        --muted: #64748b;
        --border: rgba(15, 23, 42, .08);
        --shadow: 0 10px 30px rgba(15, 23, 42, .08);
        --shadow2: 0 14px 38px rgba(15, 23, 42, .10);
        --primary: #4f46e5;
        --primary2: #3b82f6;

        background: radial-gradient(900px 500px at 20% 0%, rgba(79, 70, 229, .10), transparent 60%),
            radial-gradient(900px 500px at 90% 30%, rgba(59, 130, 246, .10), transparent 60%),
            var(--bg);
        padding: 28px 0 48px;
    }

    .blog-container {
        width: min(1120px, calc(100% - 32px));
        margin: 0 auto;
    }

    /* ====== HERO ====== */
    .hero {
        display: grid;
        grid-template-columns: 1.15fr .85fr;
        gap: 18px;
        align-items: stretch;
        margin-bottom: 18px;
    }

    .kicker {
        font-size: 12px;
        letter-spacing: .14em;
        text-transform: uppercase;
        color: var(--muted);
        font-weight: 800;
        margin-bottom: 10px;
    }

    .hero-title {
        margin: 0;
        color: var(--text);
        font-size: clamp(26px, 3vw, 40px);
        line-height: 1.1;
        letter-spacing: -.02em;
        font-weight: 1000;
    }

    .hero-sub {
        margin: 10px 0 0;
        color: var(--muted);
        line-height: 1.75;
        max-width: 70ch;
        font-size: 14px;
    }

    .hero-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 14px;
    }

    /* Buttons */
    .btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        border-radius: 14px;
        border: 1px solid var(--border);
        background: rgba(255, 255, 255, .75);
        color: var(--text);
        font-weight: 900;
        font-size: 14px;
        text-decoration: none;
        transition: .18s ease;
    }

    .btn:hover {
        transform: translateY(-1px);
        box-shadow: var(--shadow);
    }

    .btn.primary {
        color: #fff;
        border: none;
        background: linear-gradient(135deg, var(--primary), var(--primary2));
    }

    .stats {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: 14px;
    }

    .stat {
        flex: 1 1 150px;
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: 16px;
        box-shadow: var(--shadow);
        padding: 12px;
    }

    .stat-num {
        font-weight: 1100;
        font-size: 18px;
        color: var(--text);
    }

    .stat-label {
        color: var(--muted);
        font-size: 13px;
        font-weight: 800;
    }

    /* Right panel */
    .panel {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: 18px;
        box-shadow: var(--shadow2);
        padding: 14px;
        height: 100%;
    }

    .panel-head h2 {
        margin: 0;
        color: var(--text);
        font-size: 16px;
        font-weight: 1100;
    }

    .panel-head p {
        margin: 6px 0 0;
        color: var(--muted);
        font-size: 13px;
    }

    .featured-list {
        margin-top: 12px;
        display: grid;
        gap: 10px;
    }

    .featured-item {
        display: grid;
        grid-template-columns: 92px 1fr;
        gap: 12px;
        padding: 10px;
        border-radius: 16px;
        border: 1px solid var(--border);
        background: rgba(15, 23, 42, .02);
    }

    .featured-img {
        border-radius: 14px;
        overflow: hidden;
        height: 92px;
    }

    .featured-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .featured-title {
        margin-top: 6px;
        font-weight: 1100;
        color: var(--text);
        line-height: 1.35;
        font-size: 14px;
    }

    .muted {
        margin-top: 6px;
        color: var(--muted);
        font-size: 12px;
        font-weight: 800;
    }

    .note {
        margin-top: 12px;
        color: var(--muted);
        font-size: 12px;
    }

    /* Pills */
    .pill {
        display: inline-flex;
        padding: 6px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 1000;
        border: 1px solid var(--border);
        background: rgba(79, 70, 229, .08);
        color: #3730a3;
    }

    /* ====== Controls ====== */
    .controls {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: 18px;
        box-shadow: var(--shadow);
        padding: 14px;
        margin: 16px 0 14px;
    }

    .control-form {
        display: grid;
        grid-template-columns: 1.2fr .8fr .8fr auto;
        gap: 12px;
        align-items: end;
    }

    .field {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .field label {
        font-size: 12px;
        font-weight: 1100;
        color: var(--muted);
    }

    .field input,
    .field select {
        width: 100%;
        padding: 11px 12px;
        border-radius: 14px;
        border: 1px solid var(--border);
        background: #fff;
        color: var(--text);
        outline: none;
        transition: .18s ease;
        font-size: 14px;
    }

    .field input:focus,
    .field select:focus {
        border-color: rgba(79, 70, 229, .45);
        box-shadow: 0 0 0 4px rgba(79, 70, 229, .12);
    }

    .actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        justify-content: flex-end;
    }

    .chips {
        margin-top: 12px;
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .chip {
        padding: 8px 10px;
        border-radius: 999px;
        border: 1px solid var(--border);
        background: #fff;
        color: var(--text);
        font-weight: 1000;
        font-size: 12px;
        text-decoration: none;
        transition: .18s ease;
    }

    .chip:hover {
        transform: translateY(-1px);
        box-shadow: var(--shadow);
    }

    .chip.active {
        border-color: transparent;
        color: #fff;
        background: linear-gradient(135deg, var(--primary), var(--primary2));
    }

    .info {
        margin-top: 10px;
        color: var(--muted);
        font-size: 13px;
    }

    /* ====== Cards ====== */
    .grid {
        display: grid;
        grid-template-columns: repeat(12, 1fr);
        gap: 14px;
    }

    .card {
        grid-column: span 4;
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: 18px;
        overflow: hidden;
        box-shadow: var(--shadow2);
        transition: .18s ease;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 18px 50px rgba(15, 23, 42, .12);
    }

    .thumb {
        position: relative;
        aspect-ratio: 16/10;
        overflow: hidden;
        background: #eef2ff;
    }

    .thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transform: scale(1.02);
        transition: transform .35s ease;
    }

    .card:hover .thumb img {
        transform: scale(1.08);
    }

    .badge {
        position: absolute;
        left: 12px;
        top: 12px;
        padding: 7px 10px;
        border-radius: 999px;
        border: 1px solid rgba(255, 255, 255, .55);
        background: rgba(15, 23, 42, .55);
        color: #fff;
        font-size: 12px;
        font-weight: 1100;
        backdrop-filter: blur(10px);
    }

    .body {
        padding: 14px;
    }

    .meta {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        color: var(--muted);
        font-size: 12px;
        font-weight: 900;
        margin-bottom: 10px;
    }

    .sep {
        opacity: .7;
    }

    .body .title {
        margin: 0;
        color: var(--text);
        font-weight: 1100;
        font-size: 16px;
        line-height: 1.35;
    }

    .excerpt {
        margin: 8px 0 0;
        color: var(--muted);
        font-size: 14px;
        line-height: 1.75;
    }

    .tags {
        margin-top: 12px;
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .tag {
        font-size: 12px;
        font-weight: 1000;
        color: #0f172a;
        border: 1px solid var(--border);
        background: rgba(15, 23, 42, .03);
        padding: 6px 9px;
        border-radius: 999px;
    }

    .readmore {
        margin-top: 12px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-weight: 1100;
        font-size: 13px;
        color: #1d4ed8;
        text-decoration: none;
        padding: 9px 10px;
        border-radius: 14px;
        border: 1px solid rgba(29, 78, 216, .18);
        background: rgba(29, 78, 216, .06);
        transition: .18s ease;
    }

    .readmore:hover {
        transform: translateY(-1px);
        box-shadow: var(--shadow);
    }

    /* Empty */
    .empty {
        grid-column: span 12;
        padding: 16px;
        border-radius: 18px;
        border: 1px dashed rgba(15, 23, 42, .18);
        color: var(--muted);
        background: rgba(255, 255, 255, .7);
    }

    /* Pagination */
    .pager {
        margin-top: 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        flex-wrap: wrap;
    }

    .pagebtn {
        padding: 10px 12px;
        border-radius: 14px;
        border: 1px solid var(--border);
        background: #fff;
        color: var(--text);
        font-weight: 1100;
        text-decoration: none;
    }

    .pagebtn.disabled {
        opacity: .45;
        pointer-events: none;
    }

    .pagenums {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .pagenum {
        width: 40px;
        height: 40px;
        display: grid;
        place-items: center;
        border-radius: 14px;
        border: 1px solid var(--border);
        background: #fff;
        color: var(--text);
        font-weight: 1100;
        text-decoration: none;
    }

    .pagenum.active {
        border-color: transparent;
        color: #fff;
        background: linear-gradient(135deg, var(--primary), var(--primary2));
    }

    /* ====== Responsive ====== */
    @media (max-width: 992px) {
        .hero {
            grid-template-columns: 1fr;
        }

        .control-form {
            grid-template-columns: 1fr 1fr;
        }

        .actions {
            justify-content: flex-start;
        }

        .card {
            grid-column: span 6;
        }
    }

    @media (max-width: 640px) {
        .control-form {
            grid-template-columns: 1fr;
        }

        .card {
            grid-column: span 12;
        }

        .featured-item {
            grid-template-columns: 1fr;
        }

        .featured-img {
            height: 160px;
        }
    }
</style>
@endsection