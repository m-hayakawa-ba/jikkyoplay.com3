<!-- 埋め込み動画 -->
<template>
    <div class="program-background">

        <!-- youtube -->
        <EmbedYoutube
            v-if="site_id == constants.site.youtube"
            :movie_id="movie_id"
        />
        <!-- ニコニコ動画 -->
        <EmbedNicovideo
            v-if="site_id == constants.site.nicovideo"
            :movie_id="movie_id"
        />
    </div>
</template>


<script>
import EmbedYoutube       from '@/js/Components/Program/EmbedYoutube.vue';
import EmbedNicovideo     from '@/js/Components/Program/EmbedNicovideo.vue';
export default {

    //読み込んだコンポーネント
    components: {
        EmbedYoutube,
        EmbedNicovideo,
    },

    //呼び出し元から渡された引数
    props: [
        "site_id",  //どの動画サイトへ遷移するか
        "movie_id", //各動画サイトごとの動画id
    ],

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
    .program-background {
        margin: 20px 0 8px;
        background-color: #000;
        border-radius: 4px;
        overflow: hidden;
        @media screen and (min-width: $bp) {
            padding: 0 72px;
        }
    }
</style>