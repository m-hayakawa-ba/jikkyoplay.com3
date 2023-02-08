<template>

    <!-- 再生回数表示 -->
    <CreaterViewCount
        :rank="rank"
        :view_count="creater.view_count"
    />

    <!-- 番組情報 -->
    <div
        class="creater-item"
        :href="'/'"
    >

        <!-- 投稿者の顔アイコン -->
        <div class="creater-image">
            <img :src="creater.user_icon_url" :alt="creater.name">
        </div>

        <!-- 投稿者の情報 -->
        <div class="caption-wrap">

            <!-- 実況者の名前 -->
            <div class="creater-name">
                {{ creater.name }}
            </div>

            <!-- その他の動画 -->
            <Link href="/" class="creater-other-program">
                <span>この実況者の他の動画を見る</span>
                <svg fill="currentColor" class="link-arrow">
                    <use xlink:href="/icon/right.svg#right"></use>
                </svg>
            </Link>

            <!-- もとのページへ -->
            <a :href="getChannelUrl()" class="site-link" target="_blank">
                <img :src="getSiteIconUrl()">
                <span>チャンネルページへ行く</span>
            </a>
        </div>

    </div>

</template>


<script>
import {Link} from "@inertiajs/inertia-vue3";
import CreaterViewCount from "@/js/Components/Creater/CreaterViewCount.vue";
export default {

    //呼び出し元から渡された引数
    props: [
        "rank",     //ランキングがある場合、何位か（ランキングじゃない場合はnull）
        "creater",  //投稿者情報
    ],

    //返り値が固定の関数
    computed: {

        //laravel側から定数を取得する
        constants() {
            return this.$page.props.const;
        },
    },

    //読み込んだコンポーネント
    components: {
        Link,
        CreaterViewCount,
    },

    //コンポーネント内で使用するメソッド
    methods: {

        //そのユーザーの外部チャンネルURLを返す
        getChannelUrl() {
            if (this.creater.site_id == this.constants.site.youtube) {
                return `https://www.youtube.com/channel/${this.creater.user_id}`;
            } else if (this.creater.site_id == this.constants.site.nicovideo) {
                return `https://www.nicovideo.jp/user/${this.creater.user_id}`;
            }
        },

        //そのユーザーの外部サイトのアイコンURLを返す
        getSiteIconUrl() {
            if (this.creater.site_id == this.constants.site.youtube) {
                return "/image/logo_youtube.webp";
            } else if (this.creater.site_id == this.constants.site.nicovideo) {
                return "/image/logo_nicovideo.webp";
            }
        },
    },

    //初回読み込み時に実行
    mounted() {

        // console.log(this.creater);
    }

}
</script>


<style lang="scss" scoped>
@import "@/sass/variables";
    .creater-item {
        margin: 0 0 4px;
        padding: 2px;
        display: flex;
        flex-wrap: nowrap;
        align-items: center;
        width: 100%;
        background-color: #fff;
        border: solid 1px #8b9699;
        border-radius: 4px;
        box-shadow: 1px 1px 2px #21003421;
    }
    .creater-image {
        width:  96px;
        height: 96px;
        img {
            object-fit: cover;
            width: 100%;
            border-radius: 2px;
            box-shadow: 1px 1px 4px rgb(32 6 6 / 12%);
        }
    }
    .caption-wrap {
        margin-left: 2px;
        padding: 2px 16px;
        width: calc(100% - 98px);
    }
    .creater-name {
        font-weight: bold;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .creater-other-program {
        display: block;
        margin-top: 2px;
        span {
            vertical-align: middle;
            font-weight: bold;
            color: $font-color-link;
        }
        .link-arrow {
            display: inline;
            position: relative;
            bottom: 0.5px;
            width: 20px;
            height: 20px;
            margin-left: 2px;
            color: $font-color-link;
            vertical-align: middle;
        }
    }
    .site-link {
        position: relative;
        display: block;
        margin: 6px 0px 0;
        padding: 2px 0 3px;
        border: solid 1px #8d8186;
        background-color: #ffffff;
        border-radius: 4px;
        text-align: center;
        font-weight: bold;
        img {
            display: inline;
            width: 28px;
            vertical-align: middle;
        }
        span {
            position: relative;
            top: 2px;
            margin-left: 4px;
            vertical-align: middle;
        }
    }

</style>