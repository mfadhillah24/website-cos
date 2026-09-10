    @extends('layouts.admin')

    @section('title', 'Pusat Notifikasi')
    @section('page_title', 'Pusat Notifikasi')

    @section('breadcrumb')
        <span class="text-muted">Dashboard</span> / <span class="font-semibold text-gray-900">Notifikasi</span>
    @endsection

    @section('content')
    <div class="card">
        <div class="card-header flex justify-between items-center">
            <h2 class="card-title">Semua Notifikasi</h2>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.notifications.index') }}" class="btn btn-sm {{ !request('filter') ? 'btn-primary' : 'btn-secondary' }}">Semua</a>
                <a href="{{ route('admin.notifications.index', ['filter' => 'unread']) }}" class="btn btn-sm {{ request('filter') === 'unread' ? 'btn-primary' : 'btn-secondary' }}">Belum Dibaca</a>
                
                <form action="{{ route('admin.notifications.mark-all-read') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-secondary" {{ $notifications->isEmpty() ? 'disabled' : '' }}>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline;vertical-align:middle;"><path d="M18 6 7 17l-5-5"/><path d="m22 10-7.5 7.5L13 16"/></svg>
                        Tandai Semua Dibaca
                    </button>
                </form>

                <form action="{{ route('admin.notifications.destroy-all') }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus semua notifikasi?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" {{ $notifications->isEmpty() ? 'disabled' : '' }}>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline;vertical-align:middle;"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                        Hapus Semua
                    </button>
                </form>
            </div>
        </div>
        
        <div class="card-body p-0">
            @if($notifications->isEmpty())
                <div class="p-6 text-center text-gray-500 py-12">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin: 0 auto 12px; display:block; color: #d1d5db;"><path d="M8.7 3A6 6 0 0 1 18 8a21.3 21.3 0 0 0 .6 5"/><path d="M17 17H3s3-2 3-9a4.67 4.67 0 0 1 .3-1.7"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/><line x1="2" y1="2" x2="22" y2="22"/></svg>
                    @if(request('filter') === 'unread')
                        Semua notifikasi sudah dibaca.
                    @else
                        Belum ada notifikasi.
                    @endif
                </div>
            @else
                <div class="flex-col">
                    @foreach($notifications as $notif)
                        <div class="flex items-start gap-4 p-4 border-b border-gray-100 hover:bg-gray-50 transition-colors {{ is_null($notif->read_at) ? 'bg-blue-50/30' : '' }}">
                            <div class="flex-shrink-0 mt-1">
                                @if(is_null($notif->read_at))
                                    <div class="w-2.5 h-2.5 rounded-full bg-blue-600 mt-2"></div>
                                @else
                                    <div class="w-2.5 h-2.5 rounded-full bg-transparent mt-2"></div>
                                @endif
                            </div>
                            
                            <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center flex-shrink-0 text-gray-600">
                                @php $notifType = $notif->data['type'] ?? ''; @endphp
                                @if(in_array($notifType, ['member_registration', 'registration_submitted']))
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
                                @elseif(in_array($notifType, ['public_message', 'incoming_letter', 'disposition_created']))
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                                @elseif(in_array($notifType, ['report_submitted', 'report_revision', 'report_approved']))
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                                @elseif(in_array($notifType, ['meeting_created', 'activity_created']))
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                @elseif($notifType === 'finance_submission')
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                                @endif
                            </div>
                            
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-900 truncate">
                                    {{ $notif->data['title'] ?? 'Notifikasi' }}
                                </p>
                                <p class="text-sm text-gray-600 mt-1">
                                    {{ $notif->data['message'] ?? '' }}
                                </p>
                                <div class="flex items-center gap-3 mt-2">
                                    <span class="text-xs text-gray-400 flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                        {{ $notif->created_at->diffForHumans() }}
                                    </span>
                                    
                                    @if(isset($notif->data['action_url']) && $notif->data['action_url'])
                                        <a href="{{ route('admin.notifications.read', $notif->id) }}" class="text-xs font-medium text-blue-600 hover:text-blue-700 flex items-center gap-1">
                                            Lihat Detail
                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                                        </a>
                                    @else
                                        @if(is_null($notif->read_at))
                                            <a href="{{ route('admin.notifications.read', $notif->id) }}" class="text-xs font-medium text-blue-600 hover:text-blue-700">
                                                Tandai sudah dibaca
                                            </a>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            
                            <div class="flex-shrink-0 ml-2">
                                <form action="{{ route('admin.notifications.destroy', $notif->id) }}" method="POST" onsubmit="return confirm('Hapus notifikasi ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="background:none;border:none;cursor:pointer;color:#9ca3af;padding:4px;" onmouseover="this.style.color='#dc2626'" onmouseout="this.style.color='#9ca3af'" title="Hapus Notifikasi">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        
        @if($notifications->hasPages())
            <div class="card-footer border-t border-gray-200">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
    @endsection
