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
     * 動画を検索して、個数とCollectionを返す
     * 
     * @param Request $request 検索やソートの条件
     * @param int     $count   取得する動画の件数
     * 
     * @return array
     */
    public function searchPrograms(Request $request, int $count) : array
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

        //検索結果の個数を取得
        $collection_count = $programs->count();

        //取得個数を設定してでーたを取得する
        $programs = $programs->limit($count)
            ->offset(($request->query('page', 1) - 1) * $count)
            ->get();

        //結果を配列で返して終了
        return [
            'count' => $collection_count,
            'programs' => $programs,
        ];
    }
}