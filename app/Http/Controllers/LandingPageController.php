<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Koleksi;

class LandingPageController extends Controller
{
    public function index()
    {
        $koleksi = Koleksi::first();
        return view('landing_page', compact('koleksi'));
    }
}
