<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {

        //viewへ遷移
        return Inertia::render('Home/Index');
    }
}
