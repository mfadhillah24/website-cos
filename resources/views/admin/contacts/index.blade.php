@extends('layouts.admin')

@section('title', 'Pesan Masuk')
@section('page_title', 'Pesan Masuk')
@section('breadcrumb', 'Sistem / Pesan Masuk')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Daftar Pesan Masuk</h2>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Pengirim</th>
                    <th>Subjek</th>
                    <th>Tanggal</th>
                    <th style="text-align:right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($contacts as $contact)
                    <tr style="{{ !$contact->is_read ? 'font-weight: 600; background-color: #f8fafc;' : '' }}">
                        <td>
                            @if($contact->is_read)
                                <span class="badge badge-gray" style="background: #e2e8f0; color: #475569; padding: 2px 8px; border-radius: 12px; font-size: 0.75rem;">Dibaca</span>
                            @else
                                <span class="badge badge-green" style="background: #dcfce7; color: #166534; padding: 2px 8px; border-radius: 12px; font-size: 0.75rem; font-weight: 600;">Baru</span>
                            @endif
                        </td>
                        <td>
                            <div>{{ $contact->name }}</div>
                            <div class="text-xs text-muted" style="font-weight: normal;">
                                @if(str_contains($contact->email, '@'))
                                    {{ $contact->email }}
                                @else
                                    WA: {{ $contact->email }}
                                @endif
                            </div>
                        </td>
                        <td>{{ Str::limit($contact->subject, 50) }}</td>
                        <td style="font-weight: normal;">
                            <div class="text-sm">{{ $contact->created_at->format('d M Y') }}</div>
                            <div class="text-xs text-muted">{{ $contact->created_at->format('H:i') }}</div>
                        </td>
                        <td>
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.contacts.show', $contact) }}" class="btn btn-primary btn-sm">Lihat</a>
                                <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}" style="display:inline;">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus pesan ini?')">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center; padding:40px;" class="text-muted">
                            Belum ada pesan masuk.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($contacts->hasPages())
    <div class="card-body border-t">
        {{ $contacts->links() }}
    </div>
    @endif
</div>
@endsection
