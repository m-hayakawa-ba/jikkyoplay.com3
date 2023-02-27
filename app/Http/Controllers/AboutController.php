<?php

namespace App\Http\Controllers;

use App\Services\Program\ProgramReadService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AboutController extends Controller
{
    /**
     * 定数定義
     */
    private $about_program_id_1 = 1;          //表示させる最新ニュース

    /**
     * コンストラクタ
     */
    public function __construct(
        private ProgramReadService $programReadService,
    ){
    }

    /**
     * このサイトについて
     */
    public function index() {

        //最初の実況プレイを取得
        $program = $this->programReadService->getProgram($this->about_program_id_1);

        //viewへ遷移
        return Inertia::render('About/Index', compact(
            'program'
        ));
    }
}
