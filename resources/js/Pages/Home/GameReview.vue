<template>

    <!-- レビュー一覧 -->
    <div
        v-for="review in reviews"
        class="review-wrap"
    >
        <ReviewWrap :review="review" />
    </div>

    <!-- レビュー一覧へのリンク -->
    <PageLink
        href="/review"
        link_name="すべてのレビューを見る"
    />
</template>


<script>
import { usePage } from "@inertiajs/inertia-vue3";
import PageLink from '@/js/Components/PageLink.vue';
import ReviewWrap from '@/js/Components/Review/ReviewWrap.vue';
export default {

    //コンポーネント内で使用する変数
    data() {
        return {
            reviews: usePage().props.value.reviews,
        };
    },

    //読み込んだコンポーネント
    components: {
        PageLink,
        ReviewWrap,
    },

    //初回読み込み時に実行
    mounted() {
        // console.log(this.reviews);
    }
}
</script>


<style lang="scss" scoped>
@import "@/sass/variables";
    .review-wrap {
        position: relative;
        margin: 8px 0 0;
        width: 100%;
        @media screen and (min-width: $bp) {
            width: 49%;
        }
    }
</style>