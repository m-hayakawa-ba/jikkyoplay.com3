<template>

    <a
        class="news-item"
        :href="news.url"
        target="_blank"
    >

        <!-- ニュースのサムネイル -->
        <div class="news-image">
            <img
                v-if="news.image_url"
                :src="news.image_url"
                @error="noImage"
            />
            <img
                v-else
                src="/image/noimage.png"
            />
        </div>

        <!-- ニュースの概略 -->
        <div class="news-caption">

            <!-- ニュースタイトル -->
            <div class="news-text">
                {{ news.title }}
            </div>

            <!-- ニュースの発信日 -->
            <div class="news-published-at">
                {{ format(news.published_at) }}
            </div>

            <!-- ニュースの発信元 -->
            <div class="news-source">
                <img v-if="news.news_source.favicon_url" :src="news.news_source.favicon_url" :alt="news.news_source.name">
                <span>{{ news.news_source.name }}</span>
            </div>
        </div>
    </a>
</template>


<script>
import moment from 'moment';
export default {

    //呼び出し元から渡された引数
    props: [
        "news", //ニュースの詳細情報の配列
    ],

    //コンポーネント内で使用するメソッド
    methods: {
        format(date) {
            return moment(date).format('YYYY年M月D日')
        },
        
        noImage(element){
            element.target.src = '/image/noimage.png'
        }
    },

}
</script>


<style lang="scss" scoped>
@import "../../../sass/variables";
    .news-item {
        margin: 0;
        padding: 2px;
        display: flex;
        flex-wrap: nowrap;
        align-items: center;
        width: 100%;
        background-color: #fff;
        border: solid 1px #8b9699;
        border-radius: 4px;
        box-shadow: 1px 1px 2px #21003421;
        cursor: pointer;
        &:hover {
            background-color: #d4f9ff;
            border-radius: 8px;
        }
    }
    .news-image {
        width: 50%;
        padding: 2px;
        img {
            aspect-ratio: 16 / 9;
            object-fit: cover;
            width: 100%;
            border-radius: 2px;
            box-shadow: 1px 1px 4px rgb(32 6 6 / 12%);
        }
    }
    .news-caption {
        width: 50%;
        padding: 4px;
    }
    .news-text {
        font-weight: bold;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 3;
        overflow: hidden;
        line-height: 2.0rem;
        word-break: break-all;
    }
    .news-published-at {
        text-align: right;
        font-size: $font-s;
        @media screen and (min-width: $bp) {
            margin-top: 8px;
        }
    }
    .news-source {
        text-align: right;
        font-size: $font-s;
        line-height: 1rem;
        img {
            display: inline;
            width: 16px;
            aspect-ratio: 1 / 1;
            object-fit: cover;
            vertical-align: middle;
        }
        span {
            margin-left: 4px;
            vertical-align: middle;
        }
    }

</style>