<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Mengambil data yang dibutuhkan, misalnya:
        $totalProjects = count(session('projects', []));
        $income = 100000000;  // Data seharusnya diambil dari database
        $expense = 5000000;   // Data seharusnya diambil dari database

        return view('dashboard', compact('totalProjects', 'income', 'expense'));
    }
}
