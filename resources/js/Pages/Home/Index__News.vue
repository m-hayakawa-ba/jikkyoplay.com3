<template>

    <!-- ニュース記事 -->
    <div
        v-for="news in newses"
        class="news-wrap"
    >
        <NewsWrap :news="news" />
    </div>
</template>


<script>
import {usePage} from "@inertiajs/inertia-vue3";
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
            margin: 0 0.5% 24px;
            width: 49%;
        }
    }

</style>