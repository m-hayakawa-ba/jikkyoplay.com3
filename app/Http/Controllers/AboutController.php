<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class AboutController extends Controller
{
    /**
     * このサイトについて
     */
    public function index() {

        //viewへ遷移
        return Inertia::render('About/Index');
    }
}
