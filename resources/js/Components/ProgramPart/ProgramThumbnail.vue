<template>
    <div class="thumbnail-wrap">

        <!-- 画像本体 -->
        <img
            :src="thumbnail_url"
            class="thumbnail-img"
        />

        <!-- YouTubeのアイコン -->
        <img
            v-if="site_id == constants.site.youtube"
            src="/image/logo_youtube.webp"
            class="thumbnail-icon"
        >

        <!-- ニコニコ動画のアイコン -->
        <img
            v-if="site_id == constants.site.nicovideo"
            src="/image/logo_nicovideo.webp"
            class="thumbnail-icon"
        >
    </div>
</template>


<script>
export default {

    //呼び出し元から渡された引数
    props: [
        "thumbnail_url",
        "site_id",
    ],

    //返り値が固定の関数
    computed: {

        //laravel側から定数を取得する
        constants() {
            return this.$page.props.const;
        },
    },

    //初回読み込み時に実行
    mounted() {
        // console.log(this.site_id);
    }
}
</script>


<style lang="scss" scoped>
@import "@/sass/variables";
    .thumbnail-wrap {
        position: relative;
        width: 100%;
        padding: 0 4px 4px 8px;
    }
    .thumbnail-img {
        aspect-ratio: 16 / 9;
        object-fit: cover;
        width: 100%;
        border-radius: 6px;
        box-shadow: 1px 1px 4px #20060654;
    }
    .thumbnail-icon {
        position: absolute;
        width: 22%;
        right: 3%;
        bottom: 3%;
    }
</style>