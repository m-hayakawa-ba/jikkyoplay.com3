<?php

namespace App\Services\Program;

use App\Models\Program;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ProgramSearchService
{
    /**
     * コンストラクタ
     */
    function __construct(
        private Program $programModel,
    ) {
    }

    /**
     * 動画を検索して表示する
     * 
     * @param Request $request 検索やソートの条件
     * @param int     $count   取得する動画の件数
     * 
     * @return Collection
     */
    public function searchPrograms(Request $request, int $count) : Collection
    {
        $programs = $this->programModel
            ->SelectIndex();
        
        //ソート順を設定
        $programs = $programs->orderBy(
            match($request->query('sort', 'date')) {
                'view'    => 'programs.view_count',
                default   => 'programs.published_at',
            },
            match($request->query('order', 'desc')) {
                'asc'     => 'asc',
                default   => 'desc',
            }
        );

        //取得個数を設定
        $programs = $programs->limit($count)
            ->offset(($request->query('page', 1) - 1) * $count);
        
        //検索したプログラムを返す
        return $programs->get();
    }
}