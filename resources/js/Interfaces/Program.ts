
//動画情報：一覧画面表示用
//app\Models\Program.php の scopeSelectIndex に一致させること
export interface SimpleProgram {
    id:            number,
    image_url:     string,
    title:         string,
    voice_id:      number,
    view_count:    number,
    published_at:  string,
    site_id:       number,
    user_icon_url: string,
    creater_name:  string,
    voice_type:    string,
};