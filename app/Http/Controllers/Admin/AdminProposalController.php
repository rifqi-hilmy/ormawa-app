<?php

namespace App\Http\Controllers\Admin;

use App\Models\Proposal;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class AdminProposalController extends Controller
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
        return view('pages.admin.proposal.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.proposal.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'tgl_kegiatan' => 'required|date',
            'surat_pengantar' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'file_proposal' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'lampiran_proposal' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'id_dosen' => 'nullable|exists:dosen,id',
            'id_dirmawa' => 'nullable|exists:users,id',
        ]);

        try {
            $suratPengantarPath = $request->file('surat_pengantar') ? $request->file('surat_pengantar')->store('proposals/surat_pengantar', 'public') : null;
            $fileProposalPath = $request->file('file_proposal')->store('proposals/file_proposal', 'public');
            $lampiranProposalPath = $request->file('lampiran_proposal') ? $request->file('lampiran_proposal')->store('proposals/lampiran_proposal', 'public') : null;

            $proposal = Proposal::create([
                'judul' => $request->judul,
                'tgl_kegiatan' => $request->tgl_kegiatan,
                'surat_pengantar' => $suratPengantarPath,
                'file_proposal' => $fileProposalPath,
                'lampiran_proposal' => $lampiranProposalPath,
                'status_dosen' => 'menunggu',
                'status_dirmawa' => 'menunggu',
                'id_user' => Auth::user()->id,
                'id_dosen' => $request->id_dosen,
                'id_dirmawa' => $request->id_dirmawa,
            ]);

            return ResponseFormatter::success($proposal, 'Proposal berhasil disimpan');
        } catch (ValidationException $e) {
            return ResponseFormatter::error($e->errors(), 'Proposal gagal ditambahkan', 422);
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Proposal gagal disimpan', 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $proposal = Proposal::findOrFail($id);
        return view('pages.admin.proposal.edit', compact('proposal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $proposal = Proposal::findOrFail($id);

            $request->validate([
                'judul' => 'required|string|max:255',
                'tgl_kegiatan' => 'required|date',
                'surat_pengantar' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
                'file_proposal' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
                'lampiran_proposal' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            ]);

            $proposal->judul = $request->judul;
            $proposal->tgl_kegiatan = $request->tgl_kegiatan;
            $proposal->id_user = Auth::id();

            if ($request->hasFile('surat_pengantar')) {
                if ($proposal->surat_pengantar && Storage::exists($proposal->surat_pengantar)) {
                    Storage::delete($proposal->surat_pengantar);
                }
                $proposal->surat_pengantar = $request->file('surat_pengantar')->store('proposals/surat_pengantar', 'public');
            }

            if ($request->hasFile('file_proposal')) {
                if ($proposal->file_proposal && Storage::exists($proposal->file_proposal)) {
                    Storage::delete($proposal->file_proposal);
                }
                $proposal->file_proposal = $request->file('file_proposal')->store('proposals/file_proposal', 'public');
            }

            if ($request->hasFile('lampiran_proposal')) {
                if ($proposal->lampiran_proposal && Storage::exists($proposal->lampiran_proposal)) {
                    Storage::delete($proposal->lampiran_proposal);
                }
                $proposal->lampiran_proposal = $request->file('lampiran_proposal')->store('proposals/lampiran_proposal', 'public');
            }

            $proposal->save();

            return ResponseFormatter::success($proposal, 'Proposal berhasil diubah');
        } catch (ValidationException $e) {
            return ResponseFormatter::error($e->errors(), 'Proposal gagal diubah', 422);
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Proposal gagal diubah', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $proposal = Proposal::findOrFail($request->id);

            $proposal->delete();

            return ResponseFormatter::success($proposal, 'Data berhasil Dihapus!');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ResponseFormatter::error($e->getMessage(), 'Server Error!', 500);
        }
    }

    public function arsipProposal(Request $request)
    {
        if ($request->wantsJson()) {
            $query = Proposal::onlyTrashed();

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
            return ResponseFormatter::success($proposal, 'Data arsip proposal berhasil diambil');
        }
        return view('pages.admin.arsip_proposal.index');
    }
}
