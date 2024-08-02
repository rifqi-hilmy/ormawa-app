<?php

namespace App\Http\Controllers\Dirmawa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DirmawaDashboardController extends Controller
{
    public function index()
    {
        return view('pages.dirmawa.dashboard');
    }
}
