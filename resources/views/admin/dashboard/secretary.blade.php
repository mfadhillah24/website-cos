@extends('layouts.admin')

@section('title', 'Dashboard Sekretaris')
@section('page_title', 'Dashboard Sekretaris')
@section('breadcrumb', 'Sekretariat')

@section('content')
<div style="margin-bottom: 8px;">
    <p style="color: var(--text-secondary); font-size: 14px;">Selamat datang, <strong>{{ auth()->user()->name }}</strong>. Berikut ringkasan administrasi sekretariat hari ini.</p>
</div>

{{-- QUICK ACTION --}}
<div class="flex gap-3" style="margin-bottom: 28px; flex-wrap: wrap;">
    <a href="{{ route('admin.letters.incoming.create') }}" class="btn btn-primary">
        <x-lucide-mail class="w-5 h-5" />
        + Surat Masuk
    </a>
    <a href="{{ route('admin.letters.outgoing.create') }}" class="btn btn-secondary">
        <x-lucide-mail class="w-5 h-5" />
        + Surat Keluar
    </a>
    <a href="{{ route('admin.agendas.create') }}" class="btn btn-secondary">
        <x-lucide-calendar-days class="w-5 h-5" />
        + Agenda
    </a>
    <a href="{{ route('admin.meetings.create') }}" class="btn btn-secondary">
        <x-lucide-circle class="w-5 h-5" />
        + Rapat
    </a>
    <a href="{{ route('admin.archives.create') }}" class="btn btn-secondary">
        <x-lucide-folder class="w-5 h-5" />
        + Arsip
    </a>
</div>

{{-- ROW 1 STATS --}}
<div class="grid-4" style="margin-bottom: 20px;">
    <div class="stat-card">
        <div class="stat-icon" style="background:#EFF6FF; border-color:#BFDBFE; color:#1E88E5;">
            <x-lucide-mail class="w-5 h-5" />
        </div>
        <div>
            <div class="stat-value">{{ $incomingTotal }}</div>
            <div class="stat-label">Total Surat Masuk</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#FEF2F2; border-color:#FECACA; color:#DC2626;">
            <x-lucide-circle class="w-5 h-5" />
        </div>
        <div>
            <div class="stat-value">{{ $incomingNew }}</div>
            <div class="stat-label">Belum Diproses</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#F0FDF4; border-color:#BBF7D0; color:#16A34A;">
            <x-lucide-mail class="w-5 h-5" />
        </div>
        <div>
            <div class="stat-value">{{ $outgoingTotal }}</div>
            <div class="stat-label">Total Surat Keluar</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background:#FFFBEB; border-color:#FDE68A; color:#D97706;">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
        </div>
        <div>
            <div class="stat-value">{{ $dispositionPending }}</div>
            <div class="stat-label">Menunggu Disposisi</div>
        </div>
    </div>
</div>

{{-- ROW 2 STATS --}}
<div class="grid-4" style="margin-bottom: 28px;">
    <div class="stat-card">
        <div class="stat-icon">
            <x-lucide-send class="w-5 h-5" />
        </div>
        <div>
            <div class="stat-value">{{ $outgoingThisMonth }}</div>
            <div class="stat-label">Surat Keluar Bulan Ini</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">
            <x-lucide-circle class="w-5 h-5" />
        </div>
        <div>
            <div class="stat-value">{{ $meetingCount }}</div>
            <div class="stat-label">Total Rapat</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">
            <x-lucide-folder class="w-5 h-5" />
        </div>
        <div>
            <div class="stat-value">{{ $archiveCount }}</div>
            <div class="stat-label">Arsip Dokumen</div>
        </div>
    </div>
    <div class="stat-card" style="{{ $agendaNext ? 'background:#F0FDF4; border-color:#BBF7D0;' : '' }}">
        <div class="stat-icon" style="{{ $agendaNext ? 'background:#DCFCE7; border-color:#BBF7D0; color:#16A34A;' : '' }}">
            <x-lucide-calendar-days class="w-5 h-5" />
        </div>
        <div style="min-width:0; flex:1;">
            @if($agendaNext)
                <div class="stat-value" style="font-size:14px; font-weight:600;">{{ \Carbon\Carbon::parse($agendaNext->agenda_date)->translatedFormat('d M Y') }}</div>
                <div class="stat-label" style="white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">{{ $agendaNext->title }}</div>
            @else
                <div class="stat-value" style="font-size:16px;">—</div>
                <div class="stat-label">Tidak ada agenda mendatang</div>
            @endif
        </div>
    </div>
</div>

{{-- RECENT INCOMING LETTERS --}}
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Surat Masuk Terbaru</h3>
        <a href="{{ route('admin.letters.incoming.index') }}" class="btn btn-secondary btn-sm">Lihat Semua</a>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>No. Agenda</th>
                    <th>No. Surat</th>
                    <th>Asal / Instansi</th>
                    <th>Perihal</th>
                    <th>Tgl Terima</th>
                    <th>Sifat</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentLetters as $letter)
                <tr>
                    <td>{{ $letter->agenda_number ?? '—' }}</td>
                    <td style="font-weight:500; font-size:12px;">{{ $letter->letter_number }}</td>
                    <td>{{ $letter->sender ?? '—' }}</td>
                    <td>{{ Str::limit($letter->subject, 40) }}</td>
                    <td style="font-size:12px;">{{ $letter->received_date ? \Carbon\Carbon::parse($letter->received_date)->format('d/m/Y') : '—' }}</td>
                    <td>
                        @if($letter->priority)
                        @php $pc = match($letter->priority) { 'Penting'=>'badge-red','Segera'=>'badge-yellow','Rahasia'=>'badge-red', default=>'badge-gray' }; @endphp
                        <span class="badge {{ $pc }}">{{ $letter->priority }}</span>
                        @else <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>
                        @php
                        $sc = match($letter->status) {
                            'baru' => 'badge-blue',
                            'diproses','didisposisikan' => 'badge-yellow',
                            'selesai' => 'badge-green',
                            'diarsipkan' => 'badge-gray',
                            default => 'badge-gray'
                        };
                        @endphp
                        <span class="badge {{ $sc }}">{{ ucfirst($letter->status) }}</span>
                    </td>
                    <td>
                        <a href="{{ route('admin.letters.incoming.show', $letter) }}" class="btn btn-secondary btn-sm">Detail</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center; color:var(--text-secondary); padding:40px;">
                        Belum ada surat masuk.
                        <a href="{{ route('admin.letters.incoming.create') }}" style="color:var(--blue-600); text-decoration:none;">Tambah sekarang →</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
