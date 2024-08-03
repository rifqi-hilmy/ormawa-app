<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Dosen;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class UserDosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $dosen = User::where('roles', 'dosen')->with('dosen.prodi');

            if ($request->filled('prodi_id')) {
                $dosen->whereHas('dosen', function ($query) use ($request) {
                    $query->where('id_prodi', $request->prodi_id);
                });
            }

            $dosen = $dosen->get();

            return ResponseFormatter::success($dosen, 'Data dosen berhasil diambil');
        }

        $prodi = Prodi::orderBy('nama_prodi', 'ASC')->get();
        return view('pages.admin.user_dosen.index', compact('prodi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $prodi = Prodi::orderBy('nama_prodi', 'ASC')->get();
        return view('pages.admin.user_dosen.create', compact('prodi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                // 'password' => 'required|string|min:8',
                'nip' => 'required|string|max:20|unique:dosen,nip',
                'nidn' => 'required|string|max:20|unique:dosen,nidn',
                'jenis_kelamin' => 'required|in:L,P',
                'alamat' => 'required|string',
                'no_hp' => 'required|string|max:15',
                'id_prodi' => 'required|exists:prodi,id',
            ]);

            $dosen = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt('password'),
                'roles' => 'dosen',
            ]);

            $dosen->dosen()->create([
                'nip' => $request->nip,
                'nidn' => $request->nidn,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'prodi' => $request->prodi,
            ]);

            return ResponseFormatter::success($dosen, 'Data dosen berhasil ditambahkan');
        } catch (ValidationException $e) {
            return ResponseFormatter::error($e->errors(), 'Data dosen gagal ditambahkan', 422);
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Data dosen gagal ditambahkan', 500);
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
        $dosen = User::where('roles', 'dosen')->with('dosen.prodi')->findOrFail($id);
        $prodi = Prodi::orderBy('nama_prodi', 'ASC')->get();
        return view('pages.admin.user_dosen.edit', compact('dosen', 'prodi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dosen = User::findOrFail($id);
        $dosenDetail = Dosen::where('id_user', $id)->first();
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $dosen->id,
                'nip' => 'required|string|max:20|unique:dosen,nip,' . $dosenDetail->id,
                'nidn' => 'required|string|max:20|unique:dosen,nidn,' . $dosenDetail->id,
                'jenis_kelamin' => 'required|in:L,P',
                'alamat' => 'required|string',
                'no_hp' => 'required|string|max:15',
                'id_prodi' => 'required|exists:prodi,id',
            ]);

            $dosen->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            $dosen->dosen()->update([
                'nip' => $request->nip,
                'nidn' => $request->nidn,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'id_prodi' => $request->id_prodi,
            ]);

            return ResponseFormatter::success($dosen, 'Data dosen berhasil diubah');
        } catch (ValidationException $e) {
            return ResponseFormatter::error($e->errors(), 'Data dosen gagal diubah', 422);
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Data dosen gagal diubah', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $dosen = User::findOrFail($request->id);

            $dosen->delete();

            return ResponseFormatter::success($dosen, 'Data berhasil Dihapus!');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ResponseFormatter::error($e->getMessage(), 'Server Error!', 500);
        }
    }
}
