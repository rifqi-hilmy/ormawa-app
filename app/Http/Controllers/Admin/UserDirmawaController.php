<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Dirmawa;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class UserDirmawaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $dirmawa = User::where('roles', 'dirmawa')->with('dirmawa')->get();
            // return ResponseFormatter::success($dirmawa, 'Data dirmawa berhasil diambil');

            if ($request->wantsJson()) {
                return ResponseFormatter::success($dirmawa, 'Data dirmawa berhasil diambil');
            }
            return view('pages.admin.user_dirmawa.index', compact('dirmawa'));
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Data dirmawa gagal diambil', 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.user_dirmawa.create');
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
                'nip' => 'required|string|max:20|unique:dirmawa,nip',
                'nidn' => 'required|string|max:20|unique:dirmawa,nidn',
                'jenis_kelamin' => 'required|in:L,P',
                'alamat' => 'required|string',
                'no_hp' => 'required|string|max:15',
            ]);

            $dirmawa = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt('password'),
                'roles' => 'dirmawa',
            ]);

            $dirmawa->dirmawa()->create([
                'nip' => $request->nip,
                'nidn' => $request->nidn,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
            ]);

            return ResponseFormatter::success($dirmawa, 'Data dirmawa berhasil ditambahkan');
        } catch (ValidationException $e) {
            return ResponseFormatter::error($e->errors(), 'Data dirmawa gagal ditambahkan', 422);
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Data dirmawa gagal ditambahkan', 500);
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
        $dirmawa = User::where('roles', 'dirmawa')->with('dirmawa')->findOrFail($id);
        return view('pages.admin.user_dirmawa.edit', compact('dirmawa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dirmawa = User::findOrFail($id);
        $dirmawaDetail = Dirmawa::where('id_user', $id)->first();
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $dirmawa->id,
                'nip' => 'required|string|max:20|unique:dirmawa,nip,' . $dirmawaDetail->id,
                'nidn' => 'required|string|max:20|unique:dirmawa,nidn,' . $dirmawaDetail->id,
                'jenis_kelamin' => 'required|in:L,P',
                'alamat' => 'required|string',
                'no_hp' => 'required|string|max:15',
            ]);

            $dirmawa = User::findOrFail($id);
            $dirmawa->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            $dirmawa->dirmawa()->update([
                'nip' => $request->nip,
                'nidn' => $request->nidn,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
            ]);

            return ResponseFormatter::success($dirmawa, 'Data Dirmawa berhasil diperbarui');
        } catch (ValidationException $e) {
            return ResponseFormatter::error($e->errors(), 'Data Dirmawa gagal diperbarui', 422);
        } catch (\Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 'Data Dirmawa gagal diperbarui', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $dirmawa = User::findOrFail($request->id);

            $dirmawa->delete();

            return ResponseFormatter::success($dirmawa, 'Data berhasil Dihapus!');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return ResponseFormatter::error($e->getMessage(), 'Server Error!', 500);
        }
    }
}
