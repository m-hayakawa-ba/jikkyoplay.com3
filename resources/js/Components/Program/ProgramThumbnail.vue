<template>
    <div class="thumbnail-wrap">
        <div class="thumbnail">
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
        padding: 2px;
    }
    .thumbnail {
        position: relative;
        width: 100%;
        height: 0;
        padding-top: calc(100% * 9 / 16);
        overflow: hidden;
        border-radius: 2px;
    }
    .thumbnail-img {
        position: absolute;
        top: 50%;
        left: 0;
        transform: translateY(-50%);
        width: 100%;
        box-shadow: 1px 1px 4px rgb(32 6 6 / 12%);
    }
    .thumbnail-icon {
        position: absolute;
        width: 22%;
        right: 3%;
        bottom: 3%;
    }
</style>