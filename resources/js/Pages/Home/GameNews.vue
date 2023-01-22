<template>
    <h2>ゲーム実況ニュース</h2>
    <section>
        <a
            v-for="news in newses"
            class="news-item"
            :href="news.url"
            target="_blank"
        >
            <div class="news-image">
                <img :src="news.image_url" />
            </div>
            <div class="news-caption">
                <div class="news-text">
                    {{ news.title }}
                </div>
                <div class="news-published-at">
                    {{ format(news.published_at) }}
                </div>
                <div class="news-source">
                    <img v-if="news.news_source.favicon_url" :src="news.news_source.favicon_url" :alt="news.news_source.name">
                    <span>{{ news.news_source.name }}</span>
                </div>
            </div>
        </a>
    </section>
</template>


<script>
import {usePage, Head} from "@inertiajs/inertia-vue3";
import moment from 'moment';
export default {

    //コンポーネント内で使用する変数
    data() {
        return {
            newses: usePage().props.value.newses,
        };
    },

    //コンポーネント内で使用するメソッド
    methods: {
        format(date) {
            return moment(date).format('YYYY年M月D日')
        }
    },

    //初回読み込み時に実行
    mounted() {
        console.log(this.newses);
    }
}
</script>


<style lang="scss" scoped>
@import "../../../sass/variables";

    section {
        padding-left: 8px;
        display: flex;
        flex-wrap: wrap;
    }
    .news-item {
        margin: 6px 0;
        display: flex;
        flex-wrap: nowrap;
        align-items: center;
        width: 100%;
        cursor: pointer;
        @media screen and (min-width: $bp) {
            width: 50%;
        }
        &:hover {
            background-color: #d4f9ff;
            border-radius: 8px;
        }
    }
    .news-image {
        width: 40%;
        padding: 4px 4px 4px 8px;
        img {
            aspect-ratio: 3 / 2;
            object-fit: cover;
            border-radius: 6px;
            box-shadow: 1px 1px 4px #20060654;
        }
    }
    .news-caption {
        width: 60%;
        padding: 4px 6px 4px 2px;
    }
    .news-text {
        font-weight: bold;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        overflow: hidden;
        @media screen and (min-width: $bp) {
            -webkit-line-clamp: 3;
        }
    }
    .news-published-at {
        text-align: right;
        font-size: $font-s;
    }
    .news-source {
        text-align: right;
        font-size: $font-s;
        img {
            display: inline;
            width: 20px;
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