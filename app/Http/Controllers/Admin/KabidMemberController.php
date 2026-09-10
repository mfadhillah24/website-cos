<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * KabidMemberController
 *
 * Menangani fitur KABID untuk melihat daftar dan detail anggota
 * yang berada di bidang yang menjadi tanggung jawabnya.
 *
 * SECURITY:
 * - Semua query di-scope berdasarkan Auth::user()->division_id
 * - Show: authorization via KabidMemberPolicy (abort 403 jika bukan bidangnya)
 * - Jika division_id null: hanya tampil empty state, TIDAK mengambil semua anggota
 */
class KabidMemberController extends Controller
{
    /**
     * Daftar anggota bidang KABID yang sedang login.
     * Query di-scope ke division_id milik user — tidak ada filter dari request.
     */
    public function index(Request $request): View
    {
        $this->authorize('view_division_members');

        $user       = Auth::user();
        $divisionId = $user->division_id;
        $division   = $divisionId ? Division::find($divisionId) : null;

        // Jika KABID belum memiliki division_id → tidak boleh lihat semua anggota
        if (!$divisionId) {
            return view('admin.kabid.members.index', [
                'members'       => collect(),
                'division'      => null,
                'noDivision'    => true,
                'search'        => '',
            ]);
        }

        $search  = $request->input('search', '');

        // Query anggota yang berada di divisi KABID pada periode aktif
        // Filter search SELALU di dalam scope division — tidak bisa bocor ke luar
        $members = Member::with(['status', 'primaryDivision.division'])
            ->whereHas('divisionMembers', function ($q) use ($divisionId) {
                $q->where('division_id', $divisionId)
                  ->whereHas('period', fn ($q2) => $q2->where('is_active', true));
            })
            ->when(
                $search,
                fn ($q) => $q->where(function ($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%")
                       ->orWhere('email', 'like', "%{$search}%")
                       ->orWhere('nta', 'like', "%{$search}%");
                })
            )
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.kabid.members.index', compact(
            'members', 'division', 'search'
        ));
    }

    /**
     * Detail anggota.
     * Authorization via KabidMemberPolicy::view() — jika anggota bukan
     * di bidang KABID, secara otomatis akan mendapat HTTP 403.
     */
    public function show(Member $member): View
    {
        // Authorize via policy — memastikan member ada di bidang KABID
        $this->authorize('view', $member);

        $user     = Auth::user();
        $division = $user->division_id ? Division::find($user->division_id) : null;

        $member->load([
            'status',
            'user',
            'primaryDivision.division',
            'statusHistories.fromStatus',
            'statusHistories.toStatus',
            'statusHistories.changer',
        ]);

        return view('admin.kabid.members.show', compact('member', 'division'));
    }
}
