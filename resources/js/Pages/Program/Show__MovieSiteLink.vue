<!-- 動画を外部動画サイトで再生する外部リンク -->
<template>

    <!-- YouTubeへのリンク -->
    <a
        v-if="site_id == constants.site.youtube"
        :href="'https://www.youtube.com/watch?v=' + movie_id"
        target="_blank"
        class="link-youtube"
    >
        <span>YouTube で見る</span>
        <SvgIcon icon="external_link" class="external-icon" />
    </a>

    <!-- ニコニコ動画へのリンク -->
    <a
        v-if="site_id == constants.site.nicovideo"
        :href="'https://www.nicovideo.jp/watch/' + movie_id"
        target="_blank"
        class="link-nicovideo"
    >
        <span>ニコニコ動画 で見る</span>
        <SvgIcon icon="external_link" class="external-icon" />
    </a>
</template>


<script>
import SvgIcon from "@/js/Components/SvgIcon.vue";
export default {

    //呼び出し元から渡された引数
    props: [
        "site_id",  //どの動画サイトへ遷移するか
        "movie_id", //各動画サイトごとの動画id
    ],

    //読み込んだコンポーネント
    components: {
        SvgIcon,
    },

    //定数の取得
    computed: {
        constants() {
            return this.$page.props.const;
        },
    },
}
</script>


<style lang="scss" scoped>
@import "@/sass/variables";
    .link-youtube, .link-nicovideo {
        display: block;
        margin: 30px auto 30px;
        width: 208px;
        text-align: center;
        font-size: 1.6rem;
        padding: 8px 0px;
        border-radius: 10px;
    }
    .link-youtube {
        color: #fff;
        background-color: #f00;
        border: solid 2px #f00;
    }
    .link-nicovideo {
        color: #fff;
        background-color: #424be4;
        border: solid 2px #424be4;
    }
    .external-icon {
        position: relative;
        bottom: 3px;
        display: inline;
        width: 24px;
        height: 24px;
        margin-left: 4px;
        vertical-align: top;
    }
</style>