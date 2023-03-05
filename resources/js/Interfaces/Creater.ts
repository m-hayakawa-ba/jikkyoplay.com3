
//動画情報：一覧画面表示用
//app\Models\Creater.php の scopeSelectIndex に加え、ランキング用の合計視聴回数を追加
export interface Creater {
    id:            number,
    name:          string,
    site_id:       number,
    user_id:       string,
    user_icon_url: string,
    view_count:    number|null,
};