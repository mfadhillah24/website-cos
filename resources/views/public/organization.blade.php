@extends('layouts.public')

@section('title', 'Struktur Organisasi')
@section('description', 'Susunan kepengurusan UKM-IT Cyber Open Source berdasarkan periode.')

@push('styles')
<style>
/* CSS Tree Hierarchy */
.org-tree {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 20px 0;
    overflow-x: auto;
}

.org-tree ul {
    padding-top: 30px;
    position: relative;
    transition: all 0.5s;
    display: flex;
    justify-content: center;
    list-style: none;
    margin: 0;
    padding-left: 0;
}

.org-tree li {
    float: left;
    text-align: center;
    list-style-type: none;
    position: relative;
    padding: 30px 10px 0 10px;
    transition: all 0.5s;
}

/* Garis vertikal di atas masing-masing node */
.org-tree li::before, .org-tree li::after {
    content: '';
    position: absolute;
    top: 0;
    right: 50%;
    border-top: 2px solid #CBD5E1;
    width: 50%;
    height: 30px;
}

.org-tree li::after {
    right: auto;
    left: 50%;
    border-left: 2px solid #CBD5E1;
}

/* Node pertama tidak punya garis sebelumnya */
.org-tree li:only-child::after, .org-tree li:only-child::before {
    display: none;
}
.org-tree li:only-child {
    padding-top: 0;
}

/* Menghilangkan border-top dari child pertama dan terakhir untuk membentuk konektor T */
.org-tree li:first-child::before, .org-tree li:last-child::after {
    border: 0 none;
}
/* Memanjangkan border vertikal untuk anak pertama dan terakhir */
.org-tree li:first-child::after {
    border-radius: 5px 0 0 0;
}
.org-tree li:last-child::before {
    border-right: 2px solid #CBD5E1;
    border-radius: 0 5px 0 0;
}

/* Garis vertikal menunjuk ke node children */
.org-tree ul::before {
    content: '';
    position: absolute;
    top: 0;
    left: 50%;
    border-left: 2px solid #CBD5E1;
    width: 0;
    height: 30px;
    transform: translateX(-1px); /* pixel perfect */
}

/* Container untuk pengurus inti yang sejajar tanpa child connector langsung dari masing-masing card */
.org-group-inti {
    display: flex;
    justify-content: center;
    gap: 30px;
    padding: 0 10px;
}

/* Container kartu anggota */
.org-node {
    display: inline-block;
    width: 200px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    border: 1px solid #E2E8F0;
    text-decoration: none;
    transition: transform 0.2s, box-shadow 0.2s;
    position: relative;
    z-index: 10;
    overflow: hidden;
}

.org-node:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

.org-node.ketua { border-top: 4px solid #1E88E5; width: 260px; }
.org-node.inti { border-top: 3px solid #0D2B85; width: 220px; }
.org-node.kabid { border-top: 3px solid #64748B; width: 220px;}
.org-node.anggota { border: 1px solid #E2E8F0; box-shadow: none; width: 180px;}

.org-photo {
    width: 100%;
    aspect-ratio: 1;
    background-color: #F8FAFC;
    display: flex;
    align-items: center;
    justify-content: center;
    border-bottom: 1px solid #F1F5F9;
}
.org-photo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.org-info {
    padding: 16px;
    text-align: center;
}
.org-info h4 {
    margin: 0 0 4px 0;
    font-size: 15px;
    font-weight: 700;
    color: #1E293B;
    line-height: 1.2;
}
.org-info p {
    margin: 0;
    font-size: 12px;
    font-weight: 600;
    color: #1E88E5;
}
.org-info p.nia {
    color: #64748B;
    font-size: 11px;
    margin-top: 4px;
    font-weight: 500;
}

.org-node.anggota .org-info { padding: 12px; }
.org-node.anggota .org-info h4 { font-size: 13px; }
.org-node.anggota .org-info p { font-size: 11px; color: #64748B;}
.org-node.anggota .org-info p.nia { font-size: 10px; }

/* Mobile responsivenes */
@media screen and (max-width: 1024px) {
    .org-tree li {
        padding: 30px 5px 0 5px; /* lebih renggang agar tdk bertumpuk */
    }
    .org-group-inti { gap: 10px; }
}

/* ============================================================
   MOBILE RESPONSIVE — ≤768px
   Desktop org-tree disembunyikan, mobile layout aktif.
   ============================================================ */
@media screen and (max-width: 768px) {
    html, body {
        overflow-x: hidden !important;
        max-width: 100vw;
    }
    /* Sembunyikan desktop tree */
    .org-tree { display: none !important; }
    /* Tampilkan mobile layout */
    .org-mobile { display: flex !important; }
    /* Hapus overflow dari inline style container */
    div[style*="overflow-x"] { overflow-x: hidden !important; }
    .section-spacing { overflow-x: hidden !important; }
}

/* ============================================================
   MOBILE ORG CHART SYSTEM
   Disembunyikan di desktop, hanya aktif saat ≤768px.
   ============================================================ */

/* Outer wrapper */
.org-mobile {
    display: none;
    flex-direction: column;
    align-items: center;
    width: 100%;
    padding: 28px 0 40px;
    box-sizing: border-box;
    overflow: hidden;
}

/* ---- Vertical line (connector) -------------------------------- */
.om-vline {
    width: 2px;
    min-height: 32px;
    background: #CBD5E1;
    flex-shrink: 0;
}

/* ---- Horizontal fork (T-branch) ------------------------------ */
/*
   Structure:
   .om-fork
     .om-fork-top      ← vertical stub coming down from parent
     .om-fork-bar      ← horizontal bar spanning both columns
     .om-fork-cols     ← flex row: left-stub  |  right-stub
*/
.om-fork {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 91%;
    max-width: 420px;
}
.om-fork-top {
    width: 2px;
    height: 20px;
    background: #CBD5E1;
}
.om-fork-bar {
    width: 100%;
    height: 2px;
    background: #CBD5E1;
    position: relative;
}
.om-fork-cols {
    display: flex;
    width: 100%;
    justify-content: space-between;
}
.om-fork-col-stub {
    width: 2px;
    height: 20px;
    background: #CBD5E1;
    flex-shrink: 0;
}

/* ---- Section label ("BIDANG") --------------------------------- */
.om-section-label {
    font-size: 10px;
    font-weight: 800;
    letter-spacing: .18em;
    text-transform: uppercase;
    color: #94A3B8;
    padding: 0 10px;
    margin: 0;
    text-align: center;
}

/* ---- Single node wrapper ------------------------------------- */
.om-node-wrap {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 91%;
    max-width: 420px;
}

/* ---- Card ---------------------------------------------------- */
.om-card {
    width: 100%;
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #E2E8F0;
    box-shadow: 0 2px 12px rgba(14, 30, 80, .07);
    overflow: hidden;
    transition: transform .2s ease, box-shadow .2s ease;
}
.om-card:active {
    transform: scale(.985);
}

/* Card accent borders by level */
.om-card.om-ketua  { border-top: 4px solid #1E88E5; }
.om-card.om-inti   { border-top: 3px solid #0D2B85; }
.om-card.om-kabid  { border-top: 3px solid #64748B; }
.om-card.om-anggota {
    border: 1px solid #E8EDF5;
    box-shadow: none;
    border-radius: 12px;
}

/* ---- Photo area --------------------------------------------- */
.om-photo {
    width: 100%;
    height: 180px;    /* consistent for Ketua, Sekretaris, Bendahara, Kabid */
    background: #F1F5F9;
    display: flex;
    align-items: center;
    justify-content: center;
    border-bottom: 1px solid #F1F5F9;
    overflow: hidden;
    flex-shrink: 0;
}
.om-photo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center center;
    display: block;
}
/* Placeholder icon centering */
.om-photo svg {
    width: 56px;
    height: 56px;
    color: #CBD5E1;
}

/* Anggota card photo: sedikit lebih pendek */
.om-card.om-anggota .om-photo {
    height: 120px;
}
.om-card.om-anggota .om-photo svg {
    width: 40px;
    height: 40px;
}

/* ---- Info area --------------------------------------------- */
.om-info {
    padding: 14px 16px 16px;
    text-align: center;
}
.om-info h4 {
    margin: 0 0 4px;
    font-size: 15px;
    font-weight: 700;
    color: #0F172A;
    line-height: 1.3;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.om-info .om-position {
    margin: 0;
    font-size: 12px;
    font-weight: 600;
    color: #1E88E5;
    line-height: 1.3;
}
.om-info .om-nia {
    margin: 4px 0 0;
    font-size: 11px;
    font-weight: 500;
    color: #94A3B8;
    line-height: 1.3;
}

/* Anggota card info */
.om-card.om-anggota .om-info {
    padding: 10px 12px 12px;
}
.om-card.om-anggota .om-info h4 {
    font-size: 12px;
}
.om-card.om-anggota .om-info .om-position {
    font-size: 10.5px;
    color: #64748B;
}
.om-card.om-anggota .om-info .om-nia {
    font-size: 10px;
}

/* ---- Divisi block: kabid + anggota bawahnya ---------------- */
.om-divisi-block {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
    /* No individual margin — spacers (om-vline) handle gaps */
}

/* ---- Anggota 2-column grid --------------------------------- */
.om-anggota-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
    width: 91%;
    max-width: 420px;
    box-sizing: border-box;
}

/* ---- Divisi section wrapper -------------------------------- */
.om-divisi-section {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
}

</style>

@endpush

@section('content')
@php
    $selectedPeriod = $activePeriod ?? $period ?? null;
    $periods = $allPeriods;
    
    // Grouping pengurus jika ada period yg terpilih
    $ketua = null;
    $sekretaris = null;
    $bendahara = null;
    $divisiData = []; // [ 'Networking' => ['kabid'=>.., 'anggota'=>[..]], ... ]

    if($selectedPeriod && $managements) {
        $ketua = $managements->where('position.order', 1)->first();
        $sekretaris = $managements->where('position.order', 2)->first();
        $bendahara = $managements->where('position.order', 3)->first();
        
        // Definition division by slug
        $divisions = [
            ['name' => 'Networking', 'kabid_slug' => 'kabid-networking', 'anggota_slug' => 'anggota-bidang-networking'],
            ['name' => 'Programming', 'kabid_slug' => 'kabid-programming', 'anggota_slug' => 'anggota-bidang-programming'],
            ['name' => 'DKV', 'kabid_slug' => 'kabid-dkv', 'anggota_slug' => 'anggota-bidang-dkv'],
            ['name' => 'Humas', 'kabid_slug' => 'humas', 'anggota_slug' => 'anggota-humas'],
        ];

        foreach($divisions as $div) {
            $kabid = $managements->where('position.slug', $div['kabid_slug'])->first();
            $anggota = $managements->where('position.slug', $div['anggota_slug'])->values();
            
            if($kabid || $anggota->count() > 0) {
                $divisiData[] = [
                    'name' => $div['name'],
                    'kabid' => $kabid,
                    'anggota' => $anggota
                ];
            }
        }
    }
@endphp

{{-- PAGE HEADER --}}
<section class="bg-white border-b border-gray-200 py-12 md:py-16">
    <div class="section-container">
        <div class="reveal fade-up max-w-4xl mx-auto text-center">
            <span class="text-secondary-blue font-semibold tracking-wider uppercase text-sm mb-2 block">Kepengurusan</span>
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-6">Struktur Organisasi</h1>
            <p class="text-lg text-gray-600 leading-relaxed mb-8">
                Silsilah dan susunan kepengurusan UKM-IT Cyber Open Source. Pilih periode untuk melihat detail struktur dari tahun ke tahun.
            </p>

            {{-- FILTER PERIODE --}}
            @if($periods->count() > 0)
                <div class="inline-block relative w-64 text-left">
                    <select onchange="window.location.href=this.value" class="block appearance-none w-full bg-white border border-gray-300 text-gray-700 py-3 px-4 pr-8 rounded-lg shadow leading-tight focus:outline-none focus:ring-2 focus:ring-primary-navy focus:border-primary-navy font-semibold cursor-pointer">
                        <option value="" disabled>-- Pilih Periode --</option>
                        @foreach($periods as $p)
                            <option value="{{ route('public.organisasi.period', $p->id) }}" {{ $selectedPeriod && $p->id == $selectedPeriod->id ? 'selected' : '' }}>
                                {{ $p->name }} {{ $p->is_active ? '(Aktif)' : '' }}
                            </option>
                        @endforeach
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

<section class="section-spacing bg-gray-50/50" style="min-height: 60vh;">
    <div class="section-container" style="max-width: 1400px; overflow-x: auto; overflow-y: visible;">
        @if($selectedPeriod && $managements->count() > 0)
            
            <div class="reveal fade-up delay-150 org-tree">
                <ul>
                    {{-- LEVEL 0: PEMBINA (Hardcoded) --}}
                    <li>
                        <div class="org-node pembina" style="background-color: #f8fafc; border: 2px solid #071A52;">
                            <div class="org-photo">
                                <x-lucide-user class="w-5 h-5 text-gray-300" />
                            </div>
                            <div class="org-info">
                                <h4>Tamus Bin Tahir, S.Pd., M.Kom.</h4>
                                <p>Pembina UKM-IT COS</p>
                                <p class="nia">NIDN: 0907078003</p>
                            </div>
                        </div>

                        <ul>
                            {{-- LEVEL 1: KETUA --}}
                            @if($ketua)
                            <li>
                        <div class="org-node ketua">
                            <div class="org-photo">
                                @if($ketua->member->photo)
                                    <img src="{{ asset('images/' . $ketua->member->photo) }}" alt="{{ $ketua->member->name }}">
                                @else
                                    <x-lucide-user class="w-5 h-5 text-gray-300" />
                                @endif
                            </div>
                            <div class="org-info">
                                <h4>{{ $ketua->member->name }}</h4>
                                <p>{{ $ketua->position->name }}</p>
                                <p class="nia">NIA: {{ $ketua->member->nta ?? $ketua->member->nim ?? '-' }}</p>
                            </div>
                        </div>

                        <ul>
                            {{-- LEVEL 2: PENGURUS INTI (Sekretaris & Bendahara dalam 1 node cabang agar garisnya di tengah) --}}
                            @if($sekretaris || $bendahara)
                                <li>
                                    <div class="org-group-inti">
                                        @if($sekretaris)
                                            <div class="org-node inti">
                                                <div class="org-photo">
                                                    @if($sekretaris->member->photo)
                                                        <img src="{{ asset('images/' . $sekretaris->member->photo) }}" alt="{{ $sekretaris->member->name }}">
                                                    @else
                                                        <x-lucide-user class="w-5 h-5 text-gray-300" />
                                                    @endif
                                                </div>
                                                <div class="org-info">
                                                    <h4>{{ $sekretaris->member->name }}</h4>
                                                    <p>{{ $sekretaris->position->name }}</p>
                                                    <p class="nia">NIA: {{ $sekretaris->member->nta ?? $sekretaris->member->nim ?? '-' }}</p>
                                                </div>
                                            </div>
                                        @endif

                                        @if($bendahara)
                                            <div class="org-node inti">
                                                <div class="org-photo">
                                                    @if($bendahara->member->photo)
                                                        <img src="{{ asset('images/' . $bendahara->member->photo) }}" alt="{{ $bendahara->member->name }}">
                                                    @else
                                                        <x-lucide-user class="w-5 h-5 text-gray-300" />
                                                    @endif
                                                </div>
                                                <div class="org-info">
                                                    <h4>{{ $bendahara->member->name }}</h4>
                                                    <p>{{ $bendahara->position->name }}</p>
                                                    <p class="nia">NIA: {{ $bendahara->member->nta ?? $bendahara->member->nim ?? '-' }}</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- LEVEL 3: PENGURUS BIDANG (Di bawah Pengurus Inti) --}}
                                    @if(count($divisiData) > 0)
                                        <ul>
                                            @foreach($divisiData as $div)
                                                <li>
                                                    {{-- Node Kabid / Humas --}}
                                                    @if($div['kabid'])
                                                        <div class="org-node kabid">
                                                            <div class="org-photo">
                                                                @if($div['kabid']->member->photo)
                                                                    <img src="{{ asset('images/' . $div['kabid']->member->photo) }}" alt="{{ $div['kabid']->member->name }}">
                                                                @else
                                                                    <x-lucide-user class="w-5 h-5 text-gray-300" />
                                                                @endif
                                                            </div>
                                                            <div class="org-info">
                                                                <h4>{{ $div['kabid']->member->name }}</h4>
                                                                <p>{{ $div['kabid']->position->name }}</p>
                                                                <p class="nia">NIA: {{ $div['kabid']->member->nta ?? $div['kabid']->member->nim ?? '-' }}</p>
                                                            </div>
                                                        </div>
                                                    @else
                                                        {{-- Dummy node if kabid is missing but has members --}}
                                                        <div class="org-node kabid" style="opacity: 0.5;">
                                                            <div class="org-info" style="padding: 20px;">
                                                                <h4 class="text-gray-400">Kosong</h4>
                                                                <p>Kepala {{ $div['name'] }}</p>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    {{-- LEVEL 4: ANGGOTA BIDANG --}}
                                                    @if(count($div['anggota']) > 0)
                                                    <ul>
                                                        @foreach($div['anggota'] as $ang)
                                                            <li>
                                                                <div class="org-node anggota">
                                                                    <div class="org-photo" style="aspect-ratio: auto; height: 140px;">
                                                                        @if($ang->member->photo)
                                                                            <img src="{{ asset('images/' . $ang->member->photo) }}" alt="{{ $ang->member->name }}">
                                                                        @else
                                                                            <x-lucide-user class="w-5 h-5 text-gray-300" />
                                                                        @endif
                                                                    </div>
                                                                    <div class="org-info">
                                                                        <h4>{{ $ang->member->name }}</h4>
                                                                        <p>{{ $ang->position->name }}</p>
                                                                        <p class="nia">NIA: {{ $ang->member->nta ?? $ang->member->nim ?? '-' }}</p>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endif
                        </ul>

                    </li>
                    @endif
                </ul>
            </div>


            {{-- ================================================================
                 MOBILE ORG CHART — hanya aktif di ≤768px via CSS
                 Desktop .org-tree di atas tidak berubah.
                 ================================================================ --}}
            <div class="org-mobile">

                {{-- ============================================================
                     LEVEL 1: KETUA UMUM
                     ============================================================ --}}
                @if($ketua)
                <div class="om-node-wrap">
                    <div class="om-card om-ketua">
                        <div class="om-photo">
                            @if($ketua->member->photo)
                                <img src="{{ asset('images/' . $ketua->member->photo) }}"
                                     alt="{{ $ketua->member->name }}">
                            @else
                                <x-lucide-user />
                            @endif
                        </div>
                        <div class="om-info">
                            <h4>{{ $ketua->member->name }}</h4>
                            <p class="om-position">{{ $ketua->position->name }}</p>
                            <p class="om-nia">NIA: {{ $ketua->member->nta ?? $ketua->member->nim ?? '-' }}</p>
                        </div>
                    </div>
                </div>
                @endif

                {{-- ============================================================
                     LEVEL 2a: SEKRETARIS
                     ============================================================ --}}
                @if($sekretaris)
                <div class="om-vline"></div>
                <div class="om-node-wrap">
                    <div class="om-card om-inti">
                        <div class="om-photo">
                            @if($sekretaris->member->photo)
                                <img src="{{ asset('images/' . $sekretaris->member->photo) }}"
                                     alt="{{ $sekretaris->member->name }}">
                            @else
                                <x-lucide-user />
                            @endif
                        </div>
                        <div class="om-info">
                            <h4>{{ $sekretaris->member->name }}</h4>
                            <p class="om-position">{{ $sekretaris->position->name }}</p>
                            <p class="om-nia">NIA: {{ $sekretaris->member->nta ?? $sekretaris->member->nim ?? '-' }}</p>
                        </div>
                    </div>
                </div>
                @endif

                {{-- ============================================================
                     LEVEL 2b: BENDAHARA
                     ============================================================ --}}
                @if($bendahara)
                <div class="om-vline"></div>
                <div class="om-node-wrap">
                    <div class="om-card om-inti">
                        <div class="om-photo">
                            @if($bendahara->member->photo)
                                <img src="{{ asset('images/' . $bendahara->member->photo) }}"
                                     alt="{{ $bendahara->member->name }}">
                            @else
                                <x-lucide-user />
                            @endif
                        </div>
                        <div class="om-info">
                            <h4>{{ $bendahara->member->name }}</h4>
                            <p class="om-position">{{ $bendahara->position->name }}</p>
                            <p class="om-nia">NIA: {{ $bendahara->member->nta ?? $bendahara->member->nim ?? '-' }}</p>
                        </div>
                    </div>
                </div>
                @endif

                {{-- ============================================================
                     LEVEL 3+: DIVISI (Kabid & Anggota)
                     Ditampilkan satu per satu secara vertikal dengan label divisi.
                     ============================================================ --}}
                @if(count($divisiData) > 0)

                {{-- Garis ke bawah lalu label BIDANG --}}
                <div class="om-vline"></div>
                <p class="om-section-label">Bidang</p>

                <div class="om-divisi-section">
                @foreach($divisiData as $div)

                    {{-- Connector dari label / divisi sebelumnya ke Kabid --}}
                    <div class="om-vline"></div>

                    <div class="om-divisi-block">

                        {{-- Label nama divisi --}}
                        <p class="om-section-label" style="margin-bottom:0;">{{ $div['name'] }}</p>
                        <div class="om-vline" style="min-height:16px;"></div>

                        {{-- Kabid Card --}}
                        @if($div['kabid'])
                        <div class="om-node-wrap">
                            <div class="om-card om-kabid">
                                <div class="om-photo">
                                    @if($div['kabid']->member->photo)
                                        <img src="{{ asset('images/' . $div['kabid']->member->photo) }}"
                                             alt="{{ $div['kabid']->member->name }}">
                                    @else
                                        <x-lucide-user />
                                    @endif
                                </div>
                                <div class="om-info">
                                    <h4>{{ $div['kabid']->member->name }}</h4>
                                    <p class="om-position">{{ $div['kabid']->position->name }}</p>
                                    <p class="om-nia">NIA: {{ $div['kabid']->member->nta ?? $div['kabid']->member->nim ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        {{-- Anggota dalam 2-column grid --}}
                        @if(count($div['anggota']) > 0)
                        <div class="om-vline"></div>
                        <div class="om-anggota-grid">
                            @foreach($div['anggota'] as $ang)
                            <div class="om-card om-anggota">
                                <div class="om-photo">
                                    @if($ang->member->photo)
                                        <img src="{{ asset('images/' . $ang->member->photo) }}"
                                             alt="{{ $ang->member->name }}">
                                    @else
                                        <x-lucide-user />
                                    @endif
                                </div>
                                <div class="om-info">
                                    <h4>{{ $ang->member->name }}</h4>
                                    <p class="om-position">{{ $ang->position->name }}</p>
                                    <p class="om-nia">NIA: {{ $ang->member->nta ?? $ang->member->nim ?? '-' }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif

                    </div>{{-- .om-divisi-block --}}

                @endforeach
                </div>{{-- .om-divisi-section --}}

                @endif{{-- divisiData --}}

            </div>{{-- .org-mobile --}}

        @else
            <div class="reveal fade-up ui-card p-16 text-center max-w-2xl mx-auto mt-8 border-dashed border-2">
                <x-lucide-users class="w-5 h-5 mx-auto text-gray-300 mb-6" />
                <h3 class="text-2xl font-bold text-gray-900 mb-3">Belum Ada Data Kepengurusan</h3>
                <p class="text-gray-500 text-lg">Data struktur organisasi untuk periode yang dipilih belum tersedia di dalam sistem.</p>
            </div>
        @endif
    </div>
</section>
@endsection
