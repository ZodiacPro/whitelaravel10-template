<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DataTables;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return view('dashboard.index');
    }
}
