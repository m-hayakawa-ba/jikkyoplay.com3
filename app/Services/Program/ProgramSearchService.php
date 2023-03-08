<?php

namespace App\Services\Program;

use App\Models\Creater;
use App\Models\Game;
use App\Models\Hard;
use App\Models\Maker;
use App\Models\Program;
use App\Models\Site;
use App\Models\Voice;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProgramSearchService
{
    /**
     * コンストラクタ
     */
    function __construct(
        private Creater $createrModel,
        private Game $gameModel,
        private Hard $hardModel,
        private Maker $makerModel,
        private Program $programModel,
        private Site $siteModel,
        private Voice $voiceModel,
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
        $programs = $this->SearchWord       ($programs, $request); //動画タイトル・実況者名・ゲーム名で絞り込み
        $programs = $this->searchSiteId     ($programs, $request); //サイトidで絞り込み
        $programs = $this->searchVoiceId    ($programs, $request); //声idで絞り込み
        $programs = $this->searchCreaterName($programs, $request); //投稿者名で絞り込み
        $programs = $this->searchCreaterId  ($programs, $request); //投稿者idで絞り込み
        $programs = $this->searchGameId     ($programs, $request); //ゲームidで絞り込み
        $programs = $this->searchHardId     ($programs, $request); //ハードidで絞り込み
        $programs = $this->searchRetro      ($programs, $request); //レトロゲーかどうかで絞り込み
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
     * 検索クエリと、クエリ削除用のクエリを取得
     * 
     * @param Request $request
     * 
     * @return array 検索クエリと、クエリ削除用のクエリの配列
     */
    public function getDeleteQueries(Request $request) : array
    {
        $query_links    = $this->deleteWord($request);          //文字列検索条件の削除
        $query_links[]  = $this->deleteSiteId($request);        //サイトidの削除
        $query_links[]  = $this->deleteVoiceId($request);       //声idの削除
        $query_links[]  = $this->deleteCreaterName($request);   //投稿者名の削除
        $query_links[]  = $this->deleteCreaterId($request);     //投稿者idの削除
        $query_links[]  = $this->deleteGameId($request);        //ゲームidの削除
        $query_links[]  = $this->deleteHardId($request);        //ハードidの削除
        $query_links[]  = $this->deleteRetro($request);         //レトロゲームの条件削除
        $query_links[]  = $this->deleteMakerName($request);     //メーカー名の削除
        $query_links[]  = $this->deleteMakerId($request);       //メーカーidの削除
        $query_links[]  = $this->deleteYear($request);          //発売年の削除

        return array_filter($query_links);
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
                ->orWhere('programs.title', 'like', '%' . $query . '%')
                //実況者名から検索
                ->orWhereHas('creater', function ($q) use ($query) {
                    $q->where('name', $query);
                });
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
            ? $programs->where('programs.voice_id', $request->query('voice_id'))
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
     * レトロゲーかどうか絞り込み
     * 
     * @param Builder $programs
     * @param Request $request
     * 
     * @return Builder
     */
    private function searchRetro(Builder $programs, Request $request) : Builder
    {
        return $request->query('retro', 0) == 1
            ? $programs->WhereRetro()
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

    /**
     * 検索条件の削除リンク作成
     * 
     * @param Request $request
     * 
     * @return array 検索条件を削除するリンク名とクエリ文字列
     */
    private function deleteWord(Request $request) : array
    {
        //返り値返却用の配列
        $result = [];

        //文字列検索があった場合
        if ($request->filled('word')) {

            //検索条件をスペースで区切って配列を作成する
            $words = preg_split(
                '/[\s]+/',
                mb_convert_kana($request->query('word'), 'as'),
                -1,
                PREG_SPLIT_NO_EMPTY
            );

            //各配列ごとに検索条件の削除リンクを作成していく
            foreach($words as $word) {
                $queries = $request->all();
                $queries['word'] = str_replace($word, "", $queries['word']);
                $result[] = [
                    "name"  => $word,
                    "query" => http_build_query($queries),
                ];
            }
        }

        //配列を返して終了
        return $result;
    }
    
    /**
     * サイトidの削除リンク作成
     * 
     * @param Request $request
     * 
     * @return array 検索条件を削除するリンク名とクエリ文字列
     */
    private function deleteSiteId(Request $request) : array
    {
        //サイトidの条件があった場合
        if ($request->filled('site_id')) {

            $queries = $request->all();
            unset($queries['site_id']);
            return [
                "name"  => $this->siteModel->find($request->site_id)->name,
                "query" => http_build_query($queries),
            ];
        } else {
            return [];
        }
    }
    
    /**
     * 声idの削除リンク作成
     * 
     * @param Request $request
     * 
     * @return array 検索条件を削除するリンク名とクエリ文字列
     */
    private function deleteVoiceId(Request $request) : array
    {
        //声idの条件があった場合
        if ($request->filled('voice_id')) {

            $queries = $request->all();
            unset($queries['voice_id']);
            return [
                "name"  => $this->voiceModel->find($request->voice_id)->type,
                "query" => http_build_query($queries),
            ];
        } else {
            return [];
        }
    }
    
    /**
     * 投稿者名の削除リンク作成
     * 
     * @param Request $request
     * 
     * @return array 検索条件を削除するリンク名とクエリ文字列
     */
    private function deleteCreaterName(Request $request) : array
    {
        //投稿者名の条件があった場合
        if ($request->filled('creater_name')) {

            $queries = $request->all();
            $creater_name = $queries['creater_name'];
            unset($queries['creater_name']);
            return [
                "name"  => $creater_name,
                "query" => http_build_query($queries),
            ];
        } else {
            return [];
        }
    }
    
    /**
     * 投稿者idの削除リンク作成
     * 
     * @param Request $request
     * 
     * @return array 検索条件を削除するリンク名とクエリ文字列
     */
    private function deleteCreaterId(Request $request) : array
    {
        //投稿者idの条件があった場合
        if ($request->filled('creater_id')) {

            $queries = $request->all();
            unset($queries['creater_id']);
            return [
                "name"  => $this->createrModel->find($request->creater_id)->name,
                "query" => http_build_query($queries),
            ];
        } else {
            return [];
        }
    }
    
    /**
     * ゲームidの削除リンク作成
     * 
     * @param Request $request
     * 
     * @return array 検索条件を削除するリンク名とクエリ文字列
     */
    private function deleteGameId(Request $request) : array
    {
        //ゲームidの条件があった場合
        if ($request->filled('game_id')) {

            $queries = $request->all();
            unset($queries['game_id']);
            return [
                "name"  => $this->gameModel->find($request->game_id)->name,
                "query" => http_build_query($queries),
            ];
        } else {
            return [];
        }
    }
    
    /**
     * ハードidの削除リンク作成
     * 
     * @param Request $request
     * 
     * @return array 検索条件を削除するリンク名とクエリ文字列
     */
    private function deleteHardId(Request $request) : array
    {
        //ハードidの条件があった場合
        if ($request->filled('hard_id')) {

            $queries = $request->all();
            unset($queries['hard_id']);
            return [
                "name"  => $this->hardModel->find($request->hard_id)->name,
                "query" => http_build_query($queries),
            ];
        } else {
            return [];
        }
    }
    
    /**
     * レトロゲームの条件削除リンク作成
     * 
     * @param Request $request
     * 
     * @return array 検索条件を削除するリンク名とクエリ文字列
     */
    private function deleteRetro(Request $request) : array
    {
        //ハードidの条件があった場合
        if ($request->query('retro', 0) == 1) {

            $queries = $request->all();
            unset($queries['retro']);
            return [
                "name"  => "レトロゲーム",
                "query" => http_build_query($queries),
            ];
        } else {
            return [];
        }
    }
    
    /**
     * メーカー名の削除リンク作成
     * 
     * @param Request $request
     * 
     * @return array 検索条件を削除するリンク名とクエリ文字列
     */
    private function deleteMakerName(Request $request) : array
    {
        //メーカー名の条件があった場合
        if ($request->filled('maker_name')) {

            $queries = $request->all();
            $maker_name = $queries['maker_name'];
            unset($queries['maker_name']);
            return [
                "name"  => $maker_name,
                "query" => http_build_query($queries),
            ];
        } else {
            return [];
        }
    }
    
    /**
     * メーカーidの削除リンク作成
     * 
     * @param Request $request
     * 
     * @return array 検索条件を削除するリンク名とクエリ文字列
     */
    private function deleteMakerId(Request $request) : array
    {
        //メーカーidの条件があった場合
        if ($request->filled('maker_id')) {

            $queries = $request->all();
            unset($queries['maker_id']);
            return [
                "name"  => $this->makerModel->find($request->maker_id)->name,
                "query" => http_build_query($queries),
            ];
        } else {
            return [];
        }
    }
    
    /**
     * 発売年の削除リンク作成
     * 
     * @param Request $request
     * 
     * @return array 検索条件を削除するリンク名とクエリ文字列
     */
    private function deleteYear(Request $request) : array
    {
        //発売年の条件があった場合
        if ($request->filled('year')) {

            $queries = $request->all();
            $year = $queries['year'];
            unset($queries['year']);
            return [
                "name"  => $year,
                "query" => http_build_query($queries),
            ];
        } else {
            return [];
        }
    }
}