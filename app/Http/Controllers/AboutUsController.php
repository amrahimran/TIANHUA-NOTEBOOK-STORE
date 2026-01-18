<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AboutUs;

class AboutUsController extends Controller
{
    public function index()
    {
        $aboutUs = new AboutUs();
        $sections = $aboutUs->all();

        return view('profile.about', compact('sections'));
    }
}
