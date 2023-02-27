<template>

    <InformationWrap :href="news.url">

        <!-- ニュースのサムネイル -->
        <div class="news-image">
            <div>
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
    </InformationWrap>
</template>


<script>
import InformationWrap from "@/js/Components/Information/InformationWrap.vue";
import moment from 'moment';
export default {

    //呼び出し元から渡された引数
    props: [
        "news", //ニュースの詳細情報の配列
    ],

    //読み込んだコンポーネント
    components: {
        InformationWrap,
    },

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
    .news-image {
        width: 50%;
        padding: 2px;
        div {
            position: relative;
            width: 100%;
            height: 0;
            padding-top: calc(100% * 9 / 16);
            border-radius: 2px;
            overflow: hidden;
            img {
                position: absolute;
                top: 50%;
                width: 100%;
                box-shadow: 1px 1px 4px rgb(32 6 6 / 12%);
                transform: translateY(-50%);
            }
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