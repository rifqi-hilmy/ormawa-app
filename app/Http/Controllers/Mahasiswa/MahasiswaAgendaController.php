<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Models\Agenda;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class MahasiswaAgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $mahasiswaId = Auth::id();

        if ($request->ajax()) {
            $agenda = Agenda::with('user')->where('id_user', $mahasiswaId)->get();
            return ResponseFormatter::success($agenda, 'Data agenda berhasil diambil');
        }
        return view('pages.mahasiswa.agenda.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.mahasiswa.agenda.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'nama_agenda' => 'required|string|max:255',
                'tgl_mulai' => 'required|date',
                'tgl_selesai' => 'nullable|date',
                'tempat' => 'required|string',
                'jam_mulai' => 'required',
                'jam_selesai' => 'nullable',
                'keterangan' => 'nullable|string',
            ]);

            $tgl_mulai = \Carbon\Carbon::parse($request->tgl_mulai)->format('Y-m-d');
            $tgl_selesai = $request->tgl_selesai ? \Carbon\Carbon::parse($request->tgl_selesai)->format('Y-m-d') : null;

            $agenda = Agenda::create([
                'nama_agenda' => $request->nama_agenda,
                'tgl_mulai' => $tgl_mulai,
                'tgl_selesai' => $tgl_selesai,
                'tempat' => $request->tempat,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'keterangan' => $request->keterangan,
                'id_user' => auth()->user()->id,
            ]);

            return ResponseFormatter::success($agenda, 'Agenda berhasil ditambahkan');
        } catch (ValidationException $e) {
            return ResponseFormatter::error($e->errors(), 'Agenda gagal ditambahkan', 422);
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Agenda gagal ditambahkan', 500);
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
        $agenda = Agenda::findOrFail($id);
        return view('pages.mahasiswa.agenda.edit', compact('agenda'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $agenda = Agenda::findOrFail($id);

            $request->validate([
                'nama_agenda' => 'required|string|max:255',
                'tgl_mulai' => 'required|date',
                'tgl_selesai' => 'nullable|date',
                'tempat' => 'required|string',
                'jam_mulai' => 'required',
                'jam_selesai' => 'nullable',
                'keterangan' => 'nullable|string',
            ]);

            $tgl_mulai = \Carbon\Carbon::parse($request->tgl_mulai)->format('Y-m-d');
            $tgl_selesai = $request->tgl_selesai ? \Carbon\Carbon::parse($request->tgl_selesai)->format('Y-m-d') : null;

            $agenda->update([
                'nama_agenda' => $request->nama_agenda,
                'tgl_mulai' => $tgl_mulai,
                'tgl_selesai' => $tgl_selesai,
                'tempat' => $request->tempat,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'keterangan' => $request->keterangan,
                'id_user' => Auth::id(),
            ]);

            return ResponseFormatter::success($agenda, 'Agenda berhasil diubah');
        } catch (ValidationException $e) {
            return ResponseFormatter::error($e->errors(), 'Agenda gagal diubah', 422);
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Agenda gagal diubah', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $agenda = Agenda::findOrFail($request->id);

            $agenda->delete();

            return ResponseFormatter::success($agenda, 'Data berhasil Dihapus!');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ResponseFormatter::error($e->getMessage(), 'Server Error!', 500);
        }
    }
}
