<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Requests\UpdateMemberRequest;
use App\Models\Member;
use App\Models\MemberStatus;
use App\Models\User;
use App\Services\MemberService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class MemberController extends Controller
{
    protected MemberService $memberService;

    public function __construct(MemberService $memberService)
    {
        $this->memberService = $memberService;
    }

    public function index(Request $request): View
    {
        $this->authorize('manage_members');

        $members = Member::with(['status', 'user', 'primaryDivision.division'])
            ->when($request->search, fn($q) => $q->where('name', 'like', "%{$request->search}%")->orWhere('email', 'like', "%{$request->search}%"))
            ->when($request->status, fn($q) => $q->where('status_id', $request->status))
            ->when($request->division, function ($q) use ($request) {
                $q->whereHas('primaryDivision', function ($q2) use ($request) {
                    $q2->where('division_id', $request->division);
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $statuses = MemberStatus::all();
        $divisions = \App\Models\Division::where('is_active', true)->get();

        return view('admin.members.index', compact('members', 'statuses', 'divisions'));
    }

    public function create(): View
    {
        $this->authorize('manage_members');
        
        $statuses = MemberStatus::all();
        $users = User::doesntHave('member')->get();
        $divisions = \App\Models\Division::where('is_active', true)->get();

        return view('admin.members.create', compact('statuses', 'users', 'divisions'));
    }

    public function store(StoreMemberRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_founder'] = $request->has('is_founder');

        $this->memberService->createMember($data, $request->file('photo'));

        return redirect()->route('admin.members.index')->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function show(Member $member): View
    {
        $this->authorize('manage_members');
        $member->load(['status', 'user', 'primaryDivision.division', 'statusHistories.fromStatus', 'statusHistories.toStatus', 'statusHistories.changer']);

        return view('admin.members.show', compact('member'));
    }

    public function edit(Member $member): View
    {
        $this->authorize('manage_members');
        
        $statuses = MemberStatus::all();
        $users = User::doesntHave('member')->orWhere('id', $member->user_id)->get();
        $divisions = \App\Models\Division::where('is_active', true)->get();
        $currentDivision = $member->primaryDivision->division_id ?? null;

        return view('admin.members.edit', compact('member', 'statuses', 'users', 'divisions', 'currentDivision'));
    }

    public function update(UpdateMemberRequest $request, Member $member): RedirectResponse
    {
        $data = $request->validated();
        $data['is_founder'] = $request->has('is_founder');

        $this->memberService->updateMember($member, $data, $request->file('photo'));

        return redirect()->route('admin.members.index')->with('success', 'Data anggota berhasil diperbarui.');
    }

    public function destroy(Member $member): RedirectResponse
    {
        $this->authorize('manage_members');
        
        $this->memberService->deleteMember($member);

        return redirect()->route('admin.members.index')->with('success', 'Anggota berhasil dihapus.');
    }
}
