@extends('layouts.admin')

@section('title', 'Detail Pesan')
@section('page_title', 'Detail Pesan')
@section('breadcrumb', 'Sistem / Pesan Masuk / Detail')

@section('content')
<div style="max-width: 800px;">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Pesan dari {{ $contact->name }}</h2>
            <a href="{{ route('admin.contacts.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>
        <div class="card-body">
            <div style="margin-bottom: 24px;">
                <div style="font-size: 0.875rem; color: #64748b; margin-bottom: 4px;">Informasi Pengirim</div>
                <div style="padding: 16px; background-color: #f8fafc; border-radius: 8px; border: 1px solid #e2e8f0;">
                    <div style="display: grid; grid-template-columns: 120px 1fr; gap: 8px; margin-bottom: 8px;">
                        <span style="font-weight: 500; color: #475569;">Nama</span>
                        <span>{{ $contact->name }}</span>
                    </div>
                    <div style="display: grid; grid-template-columns: 120px 1fr; gap: 8px; margin-bottom: 8px;">
                        <span style="font-weight: 500; color: #475569;">Kontak (Email/WA)</span>
                        <span>
                            @if(str_contains($contact->email, '@'))
                                <a href="mailto:{{ $contact->email }}" style="color: #2563eb; text-decoration: none;">{{ $contact->email }}</a>
                            @else
                                @php
                                    $waNumber = preg_replace('/[^0-9]/', '', $contact->email);
                                    if (str_starts_with($waNumber, '0')) $waNumber = '62' . substr($waNumber, 1);
                                    $waLink = 'https://wa.me/' . $waNumber;
                                @endphp
                                <a href="{{ $waLink }}" target="_blank" rel="noopener"
                                   style="display:inline-flex; align-items:center; gap:6px; color:#16a34a; font-weight:600; text-decoration:none;">
                                    <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                    {{ $contact->email }} — Chat via WA
                                </a>
                            @endif
                        </span>
                    </div>
                    <div style="display: grid; grid-template-columns: 120px 1fr; gap: 8px;">
                        <span style="font-weight: 500; color: #475569;">Waktu Kirim</span>
                        <span>{{ $contact->created_at->format('d F Y, H:i') }}</span>
                    </div>
                </div>
            </div>

            <div style="margin-bottom: 24px;">
                <div style="font-size: 0.875rem; color: #64748b; margin-bottom: 4px;">Subjek</div>
                <div style="font-size: 1.125rem; font-weight: 600;">
                    {{ $contact->subject }}
                </div>
            </div>

            <div>
                <div style="font-size: 0.875rem; color: #64748b; margin-bottom: 4px;">Isi Pesan</div>
                <div style="padding: 20px; background-color: #ffffff; border-radius: 8px; border: 1px solid #e2e8f0; white-space: pre-wrap; line-height: 1.6;">{{ $contact->message }}</div>
            </div>
            
            <div style="margin-top: 32px; padding-top: 24px; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end;">
                <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus pesan ini secara permanen?')">Hapus Pesan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
