<template>

    <!-- サイト本体部分 -->
    <div class="inner">
        
        <!-- おすすめ動画レビュー -->
        <H2Title
            title_jp="おすすめ動画レビュー"
            title_en="GAME REVIEW"
        />

        <!-- レビュー一覧 -->
        <section>
            <div class="review-item">
                <template
                    v-for="(review, index) in reviews"
                    :key="review.id"
                >
                    <ReviewWrap
                        :review="review"
                        :review_all_flag="true"
                    />
                </template>
            </div>
        </section>

        <!-- ページネーション -->
        <Pagination
            :page_current="Number(page)"
            :page_last="Number(page_last)"
            base_url="/review"
            :queries="[]"
        />

    </div>
</template>


<script lang="ts">
import { defineComponent } from "vue";
import {usePage} from "@inertiajs/inertia-vue3";
import H2Title from "@/js/Components/H2Title.vue";
import ReviewWrap from '@/js/Components/Review/ReviewWrap.vue';
import Pagination from '@/js/Components/Pagination.vue';

export default defineComponent({

    //コンポーネント内で使用する変数
    data() {
        return {
            reviews: usePage().props.value.reviews,
            page: usePage().props.value.page,
            page_last: usePage().props.value.page_last,
        };
    },

    //読み込んだコンポーネント
    components: {
        H2Title,
        ReviewWrap,
        Pagination,
    },

});
</script>


<style lang="scss" scoped>
@import "@/sass/variables";
    section {
        margin-top: 4px;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        @media screen and (min-width: $bp) {
            padding-left: 8px;
        }
    }
    .review-item {
        position: relative;
        margin-bottom: 12px;
        width: 100%;
        @media screen and (min-width: $bp) {
            margin: 0 0 24px;
            width: 100%;
        }
    }
</style>