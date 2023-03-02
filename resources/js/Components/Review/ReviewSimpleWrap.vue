<template>
    <InformationWrap>
        <!-- レビュー本文 -->
        <div
            v-html="review.detail"
            class="review-detail"
        ></div>

        <!-- 投稿日とレビュワー名 -->
        <div class="review-reviewer">
            {{ format(review.created_at) }}<br>
            reviewer:{{ review.reviewer }}
        </div>
    </InformationWrap>
</template>


<script>
import moment          from 'moment';
import InformationWrap from "@/js/Components/Information/InformationWrap.vue";
export default {

    //呼び出し元から渡された引数
    props: [
        "review",
    ],

    //読み込んだコンポーネント
    components: {
        InformationWrap,
    },

    //コンポーネント内で使用するメソッド
    methods: {

        //日時の表示
        format(date) {
            return moment(date).format('YYYY年M月D日')
        },
    }
}
</script>


<style lang="scss" scoped>
@import "@/sass/variables";
    .review-detail {
        width: 100%;
        white-space: pre-line;
    }
    .review-reviewer {
        width: 100%;
        font-size: $font-s;
        text-align: right;
        color: #666;
    }
</style>