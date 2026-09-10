@extends('layouts.admin')
@section('title', 'Surat Masuk')
@section('page_title', 'Surat Masuk')
@section('breadcrumb', 'Administrasi / Surat Masuk')

@section('content')
<div class="card">
    <div class="card-header" style="flex-wrap: wrap; gap: 8px;">
        <h3 class="card-title">Daftar Surat Masuk</h3>
        <div style="display:flex; gap:8px; align-items:center; flex-wrap:wrap;">
            <a href="{{ route('admin.letters.incoming.archive.index') }}" class="btn btn-secondary" style="display:flex;align-items:center;gap:6px;">
                <svg viewBox="0 0 24 24" style="width:16px;height:16px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;stroke-linejoin:round;"><path d="M21 8v13H3V8"/><path d="M1 3h22v5H1z"/><line x1="10" y1="12" x2="14" y2="12"/></svg>
                Arsip Surat
            </a>
            <a href="{{ route('admin.letters.incoming.create') }}" class="btn btn-primary">+ Tambah Surat</a>
        </div>
    </div>
    <div class="card-body">
        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="alert alert-success" style="background:#d1fae5;border:1px solid #6ee7b7;color:#065f46;padding:12px 16px;border-radius:8px;margin-bottom:16px;">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger" style="background:#fee2e2;border:1px solid #fca5a5;color:#991b1b;padding:12px 16px;border-radius:8px;margin-bottom:16px;">
                {{ session('error') }}
            </div>
        @endif

        <form method="GET" class="flex gap-3" style="margin-bottom:20px; flex-wrap:wrap;">
            <input type="text" name="search" class="form-control" placeholder="Cari nomor, pengirim, perihal..." value="{{ request('search') }}" style="width:250px;">
            <select name="status" class="form-control" style="width:160px;">
                <option value="">Semua Status</option>
                <option value="baru" @selected(request('status')=='baru')>Baru</option>
                <option value="diproses" @selected(request('status')=='diproses')>Diproses</option>
                <option value="didisposisikan" @selected(request('status')=='didisposisikan')>Didisposisikan</option>
                <option value="selesai" @selected(request('status')=='selesai')>Selesai</option>
                <option value="diarsipkan" @selected(request('status')=='diarsipkan')>Diarsipkan</option>
            </select>
            <button type="submit" class="btn btn-secondary">Filter</button>
            @if(request()->anyFilled(['search','status']))
                <a href="{{ route('admin.letters.incoming.index') }}" class="btn btn-secondary">Reset</a>
            @endif
        </form>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>No. Agenda</th>
                        <th>No. Surat</th>
                        <th>Pengirim</th>
                        <th>Perihal</th>
                        <th>Tgl Terima</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($letters as $letter)
                    <tr>
                        <td>{{ $letter->agenda_number ?? '-' }}</td>
                        <td>{{ $letter->letter_number }}</td>
                        <td>{{ $letter->sender }}</td>
                        <td>{{ $letter->subject }}</td>
                        <td>{{ $letter->received_date->format('d/m/Y') }}</td>
                        <td>
                            @if($letter->status === 'diarsipkan')
                                <span class="badge" style="background:#f3e8ff;color:#7c3aed;border:1px solid #c4b5fd;font-size:11px;padding:3px 8px;border-radius:20px;font-weight:600;">
                                     Diarsipkan
                                </span>
                            @elseif($letter->status === 'baru')
                                <span class="badge badge-blue">Baru</span>
                            @elseif($letter->status === 'diproses')
                                <span class="badge" style="background:#fef3c7;color:#92400e;border:1px solid #fcd34d;font-size:11px;padding:3px 8px;border-radius:20px;">Diproses</span>
                            @elseif($letter->status === 'didisposisikan')
                                <span class="badge" style="background:#dbeafe;color:#1e40af;border:1px solid #93c5fd;font-size:11px;padding:3px 8px;border-radius:20px;">Didisposisikan</span>
                            @elseif($letter->status === 'selesai')
                                <span class="badge" style="background:#d1fae5;color:#065f46;border:1px solid #6ee7b7;font-size:11px;padding:3px 8px;border-radius:20px;">Selesai</span>
                            @else
                                <span class="badge badge-blue">{{ ucfirst($letter->status) }}</span>
                            @endif
                        </td>
                        <td>
                            <div style="display:flex; gap:6px; flex-wrap:wrap;">
                                <a href="{{ route('admin.letters.incoming.show', $letter) }}" class="btn btn-secondary btn-sm">Detail</a>

                                {{-- Tombol Arsipkan (hanya tampil jika belum diarsipkan) --}}
                                @if($letter->status !== 'diarsipkan')
                                    <form action="{{ route('admin.letters.incoming.archive', $letter) }}" method="POST" class="form-archive">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn btn-sm" style="background:#ede9fe;color:#5b21b6;border:1px solid #c4b5fd;" title="Arsipkan surat ini">
                                            📁 Arsipkan
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.letters.incoming.unarchive', $letter) }}" method="POST" class="form-unarchive">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn btn-sm" style="background:#ecfdf5;color:#065f46;border:1px solid #6ee7b7;" title="Kembalikan dari arsip">
                                            ↩ Kembalikan
                                        </button>
                                    </form>
                                @endif

                                {{-- Tombol Hapus --}}
                                <form action="{{ route('admin.letters.incoming.destroy', $letter) }}" method="POST" class="form-delete">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus surat ini">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center">Belum ada data surat masuk.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div style="margin-top:20px;">{{ $letters->links() }}</div>
    </div>
</div>

{{-- Dialog Konfirmasi Arsipkan --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Konfirmasi Arsipkan
    document.querySelectorAll('.form-archive').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            if (confirm('Apakah Anda yakin ingin mengarsipkan surat ini?\n\nSurat akan tetap ada di daftar surat masuk dengan status "Diarsipkan" dan akan muncul di halaman Arsip Surat.')) {
                form.submit();
            }
        });
    });

    // Konfirmasi Kembalikan
    document.querySelectorAll('.form-unarchive').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            if (confirm('Kembalikan surat ini dari arsip?\n\nStatus surat akan dikembalikan ke kondisi sebelum diarsipkan.')) {
                form.submit();
            }
        });
    });

    // Konfirmasi Hapus
    document.querySelectorAll('.form-delete').forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            if (confirm('Apakah Anda yakin ingin menghapus surat ini?\n\nData yang dihapus tidak dapat ditampilkan kembali.')) {
                form.submit();
            }
        });
    });
});
</script>
@endsection