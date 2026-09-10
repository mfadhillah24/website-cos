<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MemberStatusHistory;
use App\Models\MemberStatus;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MemberStatusController extends Controller
{
    public function index(Request $request): View
    {
        $this->authorize('manage_members');

        $histories = MemberStatusHistory::with(['member', 'fromStatus', 'toStatus', 'changer'])
            ->when($request->search, fn ($q) => $q->whereHas('member', fn ($m) => $m->where('name', 'like', "%{$request->search}%")))
            ->when($request->status, fn ($q) => $q->where('to_status_id', $request->status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $statuses = MemberStatus::all();

        return view('admin.member_statuses.index', compact('histories', 'statuses'));
    }
}
