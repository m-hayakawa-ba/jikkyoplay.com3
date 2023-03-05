
//ゲーム実況ニュース
export interface News {
    id:           number,
    title:        string,
    url:          string,
    image_url:    string,
    published_at: string,
    news_source: {
        id:          number,
        favicon_url: string,
    },
};