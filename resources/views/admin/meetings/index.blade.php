@extends('layouts.admin')

@section('title', 'Rapat Organisasi')
@section('page_title', 'Rapat Organisasi')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Daftar Rapat Organisasi</h2>
        <a href="{{ route('admin.meetings.create') }}" class="btn btn-primary">Tambah Baru</a>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Topik</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Peserta Hadir</th>
                    <th>Notulen</th>
                    <th style="text-align:right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($meetings as $meeting)
                    @php
                        $bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                                  'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                        $tgl = $meeting->meeting_date;
                        $tanggalFmt = $tgl->day . ' ' . $bulan[$tgl->month] . ' ' . $tgl->year;
                        $waktuFmt = '';
                        if ($meeting->start_time && $meeting->end_time) {
                            $waktuFmt = \Carbon\Carbon::parse($meeting->start_time)->format('H:i')
                                      . ' – '
                                      . \Carbon\Carbon::parse($meeting->end_time)->format('H:i')
                                      . ' WITA';
                        } elseif ($meeting->start_time) {
                            $waktuFmt = \Carbon\Carbon::parse($meeting->start_time)->format('H:i') . ' WITA';
                        }
                    @endphp
                    <tr>
                        <td>{{ $meeting->title }}</td>
                        <td>{{ $tanggalFmt }}</td>
                        <td>{{ $waktuFmt ?: '—' }}</td>
                        <td>
                            @if ($meeting->attendance_count !== null)
                                {{ $meeting->attendance_count }} orang
                            @else
                                <span style="color:#94a3b8;">—</span>
                            @endif
                        </td>
                        <td>
                            @if ($meeting->minute)
                                <span style="color:#16a34a; font-weight:500;">✓ Ada</span>
                            @else
                                <span style="color:#94a3b8;">Belum</span>
                            @endif
                        </td>
                        <td style="text-align:right">
                            <a href="{{ route('admin.meetings.show', $meeting) }}" class="btn btn-secondary btn-sm">Lihat</a>
                            <a href="{{ route('admin.meetings.edit', $meeting) }}" class="btn btn-secondary btn-sm">Edit</a>
                            <form method="POST" action="{{ route('admin.meetings.destroy', $meeting) }}" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus rapat ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align:center; padding:20px;">Belum ada data.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($meetings->hasPages())
        <div style="padding:16px;">
            {{ $meetings->links() }}
        </div>
    @endif
</div>
@endsection