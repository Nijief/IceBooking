<?php

namespace App\Http\Controllers;

use App\Models\Skate;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        $skates = Skate::where('is_available', true)
            ->where('quantity', '>', 0)
            ->get();
            
        return view('site.index', compact('skates'));
    }
}