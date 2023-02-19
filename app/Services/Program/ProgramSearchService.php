<?php

namespace App\Services\Program;

use App\Models\Program;
use Illuminate\Database\Eloquent\Builder;
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
        //必要なselectとwhereを設定
        $programs = $this->programModel
            ->SelectIndex();
        
        //ソート順を設定（デフォルト値はControllerで設定済み）
        $programs = $programs->SetOrderBy(
            $request->sort,
            $request->order,
        );

        //検索条件を追加
        $programs = $this->searchCreater($programs, $request); //投稿者で絞り込み
        $programs = $this->searchGame   ($programs, $request); //ゲームで絞り込み
        $programs = $this->searchHard   ($programs, $request); //ハードで絞り込み
        $programs = $this->searchMaker  ($programs, $request); //メーカーで絞り込み
        $programs = $this->searchYear   ($programs, $request); //発売年で絞り込み

        //検索結果の個数を取得
        $collection_count = $programs->count();

        //取得個数を設定してデータを取得する
        $programs = $programs->limit($count)
            ->offset(($request->query('page', 1) - 1) * $count)
            ->get();

        //結果を配列で返して終了
        return [
            'count' => $collection_count,
            'programs' => $programs,
        ];
    }

    /**
     * ページネーションの最大ページ番号を返却する
     * 
     * @param int $max_item すべての要素数
     * @param int $per_page 1ページあたりの要素数
     * 
     * @return int 最大ページ番号
     */
    public function getMaxPageNumber(int $max_item, int $per_page) : int
    {
        return ceil($max_item / $per_page);
    }

    /**
     * 検索条件
     * 投稿者の絞り込み
     * 
     * @param Builder $programs
     * @param Request $request
     * 
     * @return Builder
     */
    private function searchCreater(Builder $programs, Request $request) : Builder
    {
        return $request->has('creater_id')
            ? $programs->where('programs.creater_id', $request->query('creater_id'))
            : $programs;
    }
    /**
     * 検索条件
     * ゲームの絞り込み
     * 
     * @param Builder $programs
     * @param Request $request
     * 
     * @return Builder
     */
    private function searchGame(Builder $programs, Request $request) : Builder
    {
        return $request->has('game_id')
            ? $programs->where('programs.game_id', $request->query('game_id'))
            : $programs;
    }
    /**
     * 検索条件
     * ハードの絞り込み
     * 
     * @param Builder $programs
     * @param Request $request
     * 
     * @return Builder
     */
    private function searchHard(Builder $programs, Request $request) : Builder
    {
        return $request->has('hard_id')
            ? $programs->where('games.hard_id', $request->query('hard_id'))
            : $programs;
    }
    /**
     * 検索条件
     * メーカーの絞り込み
     * 
     * @param Builder $programs
     * @param Request $request
     * 
     * @return Builder
     */
    private function searchMaker(Builder $programs, Request $request) : Builder
    {
        return $request->has('maker_id')
            ? $programs->where('games.maker_id', $request->query('maker_id'))
            : $programs;
    }
    /**
     * 検索条件
     * 発売年の絞り込み
     * 
     * @param Builder $programs
     * @param Request $request
     * 
     * @return Builder
     */
    private function searchYear(Builder $programs, Request $request) : Builder
    {
        return $request->has('releace_year')
            ? $programs->where('games.releace_year', $request->query('releace_year'))
            : $programs;
    }
}