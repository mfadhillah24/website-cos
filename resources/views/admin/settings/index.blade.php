@extends('layouts.admin')

@section('title', 'Pengaturan Website')
@section('page_title', 'Pengaturan Website')
@section('breadcrumb', 'Sistem / Pengaturan Website')

@section('content')
<div style="max-width: 900px;">

    @if(session('success'))
        <div class="alert alert-success" style="margin-bottom:16px;">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
        @csrf

        {{-- Tab Navigation --}}
        <div style="display:flex; gap:0; margin-bottom:20px; border-bottom:2px solid #e2e8f0;">
            @foreach($settings as $group => $groupSettings)
            <button type="button"
                onclick="switchTab('{{ $group }}')"
                id="tab-btn-{{ $group }}"
                style="padding:10px 20px; border:none; background:none; font-size:13px; font-weight:600; cursor:pointer;
                       border-bottom:3px solid {{ $loop->first ? '#1E88E5' : 'transparent' }};
                       color:{{ $loop->first ? '#1E88E5' : '#64748B' }};
                       margin-bottom:-2px; transition:all 0.2s;">
                @if($group === 'general') ⚙️ Umum
                @elseif($group === 'about') 🏫 Tentang UKM
                @elseif($group === 'social') 📱 Media Sosial
                @elseif($group === 'contact') 📞 Kontak
                @else {{ ucfirst($group) }}
                @endif
            </button>
            @endforeach
        </div>

        {{-- Tab Content --}}
        @foreach($settings as $group => $groupSettings)
        <div id="tab-{{ $group }}" style="{{ $loop->first ? '' : 'display:none;' }}">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">
                        @if($group === 'general') Pengaturan Umum
                        @elseif($group === 'about') Profil & Tentang UKM
                        @elseif($group === 'social') Media Sosial
                        @elseif($group === 'contact') Informasi Kontak
                        @else {{ ucfirst($group) }}
                        @endif
                    </h2>
                    <p style="font-size:13px; color:#64748B; margin-top:4px;">
                        @if($group === 'about') Data ini akan tampil di halaman <strong>Tentang UKM</strong> pada website publik (visi, misi, sejarah).
                        @elseif($group === 'general') Pengaturan dasar tampilan website.
                        @elseif($group === 'social') Link media sosial di footer dan halaman kontak.
                        @elseif($group === 'contact') Informasi kontak untuk halaman kontak publik.
                        @endif
                    </p>
                </div>
                <div class="card-body">
                    @foreach($groupSettings as $setting)
                        <div class="form-group">
                            <label class="form-label" for="setting_{{ $setting->key }}">{{ $setting->label }}</label>

                            @if($setting->type == 'textarea')
                                <textarea
                                    id="setting_{{ $setting->key }}"
                                    name="{{ $setting->key }}"
                                    rows="{{ in_array($setting->key, ['org_vision','org_mission','org_history']) ? 7 : 3 }}"
                                    class="form-control"
                                    placeholder="Belum diisi..."
                                >{{ old($setting->key, $setting->value) }}</textarea>
                                @if(in_array($setting->key, ['org_vision','org_mission']))
                                    <small style="color:#94A3B8; font-size:12px; margin-top:4px; display:block;">
                                        💡 Untuk misi: pisahkan setiap poin dengan baris baru (Enter). Setiap baris akan tampil sebagai item terpisah.
                                    </small>
                                @endif

                            @elseif($setting->type == 'image')
                                @if($setting->value)
                                    <div style="margin-bottom:10px;">
                                        <img src="{{ asset('images/' . $setting->value) }}" alt="{{ $setting->label }}"
                                             style="max-height:80px; border-radius:8px; border:1px solid #e2e8f0; padding:4px;">
                                    </div>
                                @endif
                                <input id="setting_{{ $setting->key }}" type="file"
                                       name="{{ $setting->key }}" accept="image/*"
                                       class="form-control" style="padding-top:6px;">

                            @else
                                <input id="setting_{{ $setting->key }}"
                                       type="{{ $setting->type == 'url' ? 'url' : 'text' }}"
                                       name="{{ $setting->key }}"
                                       value="{{ old($setting->key, $setting->value) }}"
                                       class="form-control"
                                       placeholder="Belum diisi...">
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach

        <div class="flex gap-3" style="margin-top:24px;">
            <button type="submit" class="btn btn-primary">Simpan Semua Pengaturan</button>
        </div>
    </form>
</div>

<script>
function switchTab(group) {
    document.querySelectorAll('[id^="tab-"]:not([id^="tab-btn-"])').forEach(el => el.style.display = 'none');
    document.querySelectorAll('[id^="tab-btn-"]').forEach(btn => {
        btn.style.borderBottomColor = 'transparent';
        btn.style.color = '#64748B';
    });
    document.getElementById('tab-' + group).style.display = '';
    const btn = document.getElementById('tab-btn-' + group);
    btn.style.borderBottomColor = '#1E88E5';
    btn.style.color = '#1E88E5';
}
</script>
@endsection

