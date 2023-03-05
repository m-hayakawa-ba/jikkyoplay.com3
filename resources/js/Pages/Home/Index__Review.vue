<template>

    <!-- レビュー一覧 -->
    <div class="review-item">
        <template
            v-for="(review, index) in reviews"
            :key="index"
        >
            <ReviewWrap
                :review="review"
                :review_all_flag="true"
            />
        </template>
    </div>
</template>


<script lang="ts">
import { defineComponent } from "vue";
import { usePage } from "@inertiajs/inertia-vue3";
import PageLink from '@/js/Components/PageLink.vue';
import ProgramWrap from '@/js/Components/Program/ProgramWrap.vue';
import ReviewWrap from '@/js/Components/Review/ReviewWrap.vue';
import moment from 'moment';

export default defineComponent({

    //コンポーネント内で使用する変数
    data() {
        return {
            reviews: usePage().props.value.reviews,
        };
    },

    //読み込んだコンポーネント
    components: {
        PageLink,
        ProgramWrap,
        ReviewWrap,
    },

    //コンポーネント内で使用するメソッド
    methods: {
        format(date: string) {
            return moment(date).format('YYYY年M月D日')
        },
    },

    //初回読み込み時に実行
    mounted() {
        // console.log(this.reviews);
    }
});
</script>


<style lang="scss" scoped>
@import "@/sass/variables";
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