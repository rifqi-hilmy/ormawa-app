<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Organisasi;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

use function Ramsey\Uuid\v1;

class UserMahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $mahasiswa = User::where('roles', 'mahasiswa')->with('mahasiswa.organisasi');

            if ($request->filled('organisasi_id')) {
                $mahasiswa->whereHas('mahasiswa', function ($query) use ($request) {
                    $query->where('id_organisasi', $request->organisasi_id);
                });
            }

            $mahasiswa = $mahasiswa->get();

            return ResponseFormatter::success($mahasiswa, 'Data mahasiswa berhasil diambil');
        }

        $organisasi = Organisasi::orderBy('nama_organisasi', 'ASC')->get();
        return view('pages.admin.user_mahasiswa.index', compact('organisasi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $organisasi = Organisasi::orderBy('nama_organisasi', 'ASC')->get();
        return view('pages.admin.user_mahasiswa.create', compact('organisasi'));
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
                'nim' => 'required|string|max:20|unique:mahasiswa,nim',
                'jenis_kelamin' => 'required|in:L,P',
                'alamat' => 'required|string',
                'no_hp' => 'required|string|max:15',
                'id_organisasi' => 'required|exists:organisasi,id',
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt('password'),
                'roles' => 'mahasiswa',
            ]);

            $user->mahasiswa()->create([
                'nim' => $request->nim,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'id_organisasi' => $request->id_organisasi,
            ]);

            return ResponseFormatter::success($user, 'Data mahasiswa berhasil ditambahkan');
        } catch (ValidationException $e) {
            return ResponseFormatter::error($e->errors(), 'Data mahasiswa gagal ditambahkan', 422);
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Data mahasiswa gagal ditambahkan', 500);
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
    public function edit($id)
    {
        $mahasiswa = User::where('roles', 'mahasiswa')->with('mahasiswa.organisasi')->findOrFail($id);
        $organisasi = Organisasi::orderBy('nama_organisasi', 'ASC')->get();
        return view('pages.admin.user_mahasiswa.edit', compact('mahasiswa', 'organisasi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $mahasiswa = User::findOrFail($id);
        $mahasiswaDetail = Mahasiswa::where('id_user', $id)->first();
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $mahasiswa->id,
                'nim' => 'required|string|max:20|unique:mahasiswa,nim,' . $mahasiswaDetail->id,
                'jenis_kelamin' => 'required|in:L,P',
                'alamat' => 'required|string',
                'no_hp' => 'required|string|max:15',
                'id_organisasi' => 'required|exists:organisasi,id',
            ]);

            $mahasiswa->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            $mahasiswa->mahasiswa()->update([
                'nim' => $request->nim,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'id_organisasi' => $request->id_organisasi,
            ]);

            return ResponseFormatter::success($mahasiswa, 'Data mahasiswa berhasil diubah');
        } catch (ValidationException $e) {
            return ResponseFormatter::error($e->errors(), 'Data mahasiswa gagal diubah', 422);
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Data mahasiswa gagal diubah', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $mahasiswa = User::findOrFail($request->id);

            $mahasiswa->delete();

            return ResponseFormatter::success($mahasiswa, 'Data berhasil Dihapus!');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ResponseFormatter::error($e->getMessage(), 'Server Error!', 500);
        }
    }
}
