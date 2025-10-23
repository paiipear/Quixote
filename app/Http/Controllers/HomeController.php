<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Route;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $origins = DB::table('routes')->select('origin')->distinct()->get();
        $destinations = DB::table('routes')->select('destination')->distinct()->get();

        return view('home', compact('origins', 'destinations'));
    }

}
