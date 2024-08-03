<?php

namespace App\Http\Controllers\Dosen;

use App\Models\Proposal;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DosenProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $query = Proposal::query();

            if ($request->has('status_dosen') && $request->status_dosen !== null) {
                $query->where('status_dosen', $request->status_dosen);
            }

            if ($request->has('status_dirmawa') && $request->status_dirmawa !== null) {
                $query->where('status_dirmawa', $request->status_dirmawa);
            }

            if ($request->has('tgl_kegiatan') && $request->tgl_kegiatan !== null) {
                $query->whereDate('tgl_kegiatan', $request->tgl_kegiatan);
            }

            $proposal = $query->get();
            return ResponseFormatter::success($proposal, 'Data proposal berhasil diambil');
        }
        return view('pages.dosen.proposal.index');
    }

    public function verifikasi(Request $request, $id)
    {
        try {
            $proposal = Proposal::findOrFail($id);
            $proposal->status_dosen = $request->status_dosen;
            $proposal->id_dosen = Auth::id();
            $proposal->save();
            return ResponseFormatter::success($proposal, 'Proposal berhasil diverifikasi');
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Gagal memverifikasi proposal', 500);
        }
    }
}
