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
        $programs = $this->SearchWord       ($programs, $request); //動画タイトル・ゲーム名で絞り込み
        $programs = $this->searchSiteId     ($programs, $request); //サイトidで絞り込み
        $programs = $this->searchVoiceId    ($programs, $request); //声idで絞り込み
        $programs = $this->searchCreaterName($programs, $request); //投稿者名で絞り込み
        $programs = $this->searchCreaterId  ($programs, $request); //投稿者idで絞り込み
        $programs = $this->searchGameId     ($programs, $request); //ゲームidで絞り込み
        $programs = $this->searchHardId     ($programs, $request); //ハードidで絞り込み
        $programs = $this->searchMakerName  ($programs, $request); //メーカー名で絞り込み
        $programs = $this->searchMakerId    ($programs, $request); //メーカーidで絞り込み
        $programs = $this->searchYear       ($programs, $request); //発売年で絞り込み

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
     * 動画タイトルの絞り込み
     * 
     * @param Builder $programs
     * @param Request $request
     * 
     * @return Builder
     */
    private function SearchWord(Builder $programs, Request $request) : Builder
    {
        //クエリがない場合は即return
        if (!$request->filled('word')) {
            return $programs;
        }

        //クエリを半角または全角のスペースで分割する
        $query = $request->query('word');
        $words = explode(" ", mb_convert_kana($query, 'as'));

        //検索ワードで検索する
        return $programs->where(function ($q) use ($query, $words) {
            $q
                //ゲームのタイトルから検索
                ->whereHas('game.game_search_names', function ($q) use ($words) {
                    $q->whereIn('search_name', $words);
                })
                //動画のタイトルから検索
                ->orWhere('programs.title', 'like', '%' . $query . '%');
        });
    }
    /**
     * 検索条件
     * サイトidの絞り込み
     * 
     * @param Builder $programs
     * @param Request $request
     * 
     * @return Builder
     */
    private function searchSiteId(Builder $programs, Request $request) : Builder
    {
        return $request->filled('site_id')
            ? $programs->where('creaters.site_id', $request->query('site_id'))
            : $programs;
    }
    /**
     * 検索条件
     * 声idの絞り込み
     * 
     * @param Builder $programs
     * @param Request $request
     * 
     * @return Builder
     */
    private function searchVoiceId(Builder $programs, Request $request) : Builder
    {
        return $request->filled('voice_id')
            ? $programs->where('creaters.voice_id', $request->query('voice_id'))
            : $programs;
    }
    /**
     * 検索条件
     * 投稿者名の絞り込み
     * 
     * @param Builder $programs
     * @param Request $request
     * 
     * @return Builder
     */
    private function searchCreaterName(Builder $programs, Request $request) : Builder
    {
        return $request->filled('creater_name')
            ? $programs->where('creaters.name', 'like', '%' . $request->query('creater_name') . '%')
            : $programs;
    }
    /**
     * 検索条件
     * 投稿者idの絞り込み
     * 
     * @param Builder $programs
     * @param Request $request
     * 
     * @return Builder
     */
    private function searchCreaterId(Builder $programs, Request $request) : Builder
    {
        return $request->filled('creater_id')
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
    private function searchGameId(Builder $programs, Request $request) : Builder
    {
        return $request->filled('game_id')
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
    private function searchHardId(Builder $programs, Request $request) : Builder
    {
        return $request->filled('hard_id')
            ? $programs->where('games.hard_id', $request->query('hard_id'))
            : $programs;
    }
    /**
     * 検索条件
     * メーカー名の絞り込み
     * 
     * @param Builder $programs
     * @param Request $request
     * 
     * @return Builder
     */
    private function searchMakerName(Builder $programs, Request $request) : Builder
    {
        return $request->filled('maker_name')
            ? $programs->where('makers.name', 'like', '%' . $request->query('maker_name') . '%')
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
    private function searchMakerId(Builder $programs, Request $request) : Builder
    {
        return $request->filled('maker_id')
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
        return $request->filled('year')
            ? $programs->where('games.releace_year', $request->query('year'))
            : $programs;
    }
}