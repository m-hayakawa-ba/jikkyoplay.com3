<template>

    <a
        :href="news.url"
        class="news-item"
        target="_blank"
    >

        <!-- ニュースのサムネイル -->
        <div class="news-image">
            <div>
                <img
                    v-if="news.image_url && did_load_news_thumbnail"
                    :src="news.image_url"
                    :alt="news.title"
                    @error="loadingErrorNewsThumbnail"
                />
                <img
                    v-else
                    src="/image/noimage.png"
                    alt="ニュース画像なし"
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
                <img
                    v-if="news.news_source.favicon_url && did_load_news_source_thumbnail"
                    :src="news.news_source.favicon_url"
                    :alt="news.news_source.name"
                    @error="loadingErrorNewsSourceThumbnail"
                >
                <img
                    v-else
                    src="/image/noimage_trans.png"
                    alt="ニュースソースアイコンなし"
                >
                <span>{{ news.news_source.name }}</span>
            </div>
        </div>
    </a>
</template>


<script lang="ts">
import { defineComponent } from "vue";
import moment from 'moment';

export default defineComponent({

    //呼び出し元から渡された引数
    props: [
        "news", //ニュースの詳細情報の配列
    ],

    //コンポーネント内で使用する変数
    data() {
        return {
            did_load_news_thumbnail: true,
            did_load_news_source_thumbnail: true,
        };
    },

    //コンポーネント内で使用するメソッド
    methods: {
        format(date: string) {
            return moment(date).format('YYYY年M月D日')
        },
        loadingErrorNewsThumbnail() {
            this.did_load_news_thumbnail = false;
        },
        loadingErrorNewsSourceThumbnail() {
            this.did_load_news_source_thumbnail = false;
        },
    },

});
</script>


<style lang="scss" scoped>
@import "../../../sass/variables";
    .news-item {
        width: 100%;
        margin-bottom: 12px;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        overflow: hidden;
    }
    .news-image {
        width: 50%;
        padding: 2px;
        div {
            position: relative;
            width: 100%;
            height: 0;
            padding-top: 58%;
            border-radius: 2px;
            overflow: hidden;
            @media screen and (min-width: $bp) {
                padding-top: 50%;
            }
            img {
                position: absolute;
                top: 50%;
                width: 100%;
                height: 100%;
                object-fit: cover;
                border-radius: 4px;
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