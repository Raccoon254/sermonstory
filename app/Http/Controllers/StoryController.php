<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class StoryController extends Controller
{
    //
    public function index(): View
    {
        return view('welcome');
    }
}
