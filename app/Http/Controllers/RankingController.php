<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class RankingController extends Controller
{
    /**
     * ランキング一覧ページ
     */
    public function index()
    {
        $programs = [];

        //viewへ遷移
        return Inertia::render('Ranking/Index', compact(
            'programs'
        ));
    }
}
