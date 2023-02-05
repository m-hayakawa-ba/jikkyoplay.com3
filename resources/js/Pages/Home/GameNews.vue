<template>

    <!-- ニュース記事 -->
    <div
        v-for="news in newses"
        class="news-wrap"
    >
        <NewsWrap :news="news" />
    </div>

    <!-- ニュース一覧へのリンク -->
    <PageLink
        href="/news"
        link_name="その他のニュース"
    />
</template>


<script>
import {usePage} from "@inertiajs/inertia-vue3";
import PageLink from '@/js/Components/PageLink.vue';
import NewsWrap from '@/js/Components/News/NewsWrap.vue';
export default {

    //コンポーネント内で使用する変数
    data() {
        return {
            newses: usePage().props.value.newses,
        };
    },

    //読み込んだコンポーネント
    components: {
        PageLink,
        NewsWrap,
    },

    //初回読み込み時に実行
    mounted() {
        // console.log(this.newses);
    }
}
</script>


<style lang="scss" scoped>
@import "@/sass/variables";
    .news-wrap {
        position: relative;
        margin: 8px 0 0;
        width: 100%;
        @media screen and (min-width: $bp) {
            width: 49%;
        }
    }

</style>