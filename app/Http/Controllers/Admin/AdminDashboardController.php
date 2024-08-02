<?php

namespace App\Http\Controllers\Admin;

use App\Models\Agenda;
use App\Models\Proposal;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $proposalDiterima = Proposal::where('status_dosen', 'diterima')
            ->orWhere('status_dirmawa', 'diterima')
            ->count();
        $proposalMenunggu = Proposal::where('status_dosen', 'menunggu')
            ->orWhere('status_dirmawa', 'menunggu')
            ->count();
        $proposalDitolak = Proposal::where('status_dosen', 'ditolak')
            ->orWhere('status_dirmawa', 'ditolak')
            ->count();
        $totalProposals = Proposal::count();
        $jumlahAgenda = Agenda::count();

        return view('pages.admin.dashboard', compact('proposalDiterima', 'proposalMenunggu', 'proposalDitolak', 'totalProposals', 'jumlahAgenda'));
    }
}
