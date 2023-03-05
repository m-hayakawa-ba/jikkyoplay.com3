<template>

    <!-- 再生回数表示 -->
    <ProgramViewCount
        :rank="null"
        :view_count="review.view_count"
    />

    <InformationWrap :href="'/program/' + review.program_id">

        <!-- 番組のサムネイル -->
        <ProgramThumbnail
            :thumbnail_url="review.image_url"
            :site_id="review.site_id"
            style="width: 45%;"
        />

        <!-- 番組の説明文 -->
        <ProgramCaption
            :title="review.title"
            :creater_name="review.creater_name"
            :creater_icon_url="review.user_icon_url"
            :published_at="review.published_at"
            style="width: 55%;"
        />

        <!-- レビュー本文 -->
        <div
            v-if="review_all_flag"
            class="review-detail-all"
            v-html="review.detail"
        ></div>
        <div
            v-else
            class="review-detail"
            v-html="review.detail"
        ></div>

        <!-- 投稿日とレビュワー名 -->
        <div
            class="review-reviewer"
        >
            {{ format(review.created_at) }}<br>
            reviewer:{{ review.reviewer }}
        </div>
    </InformationWrap>
</template>


<script lang="ts">
import { defineComponent } from "vue";
import ProgramViewCount from "@/js/Components/Program/ProgramViewCount.vue";
import ProgramThumbnail from "@/js/Components/Program/ProgramThumbnail.vue";
import ProgramCaption from "@/js/Components/Program/ProgramCaption.vue";
import InformationWrap from "@/js/Components/Information/InformationWrap.vue";
import moment          from 'moment';

export default defineComponent({

    //呼び出し元から渡された引数
    props: [
        "review",
        "review_all_flag",
    ],

    //読み込んだコンポーネント
    components: {
        ProgramViewCount,
        ProgramThumbnail,
        ProgramCaption,
        InformationWrap,
    },

    //コンポーネント内で使用するメソッド
    methods: {

        //日時の表示
        format(date: string) {
            return moment(date).format('YYYY年M月D日')
        },
    },
});
</script>


<style lang="scss" scoped>
@import "@/sass/variables";
    .review-detail {
        height: 70px;
        padding: 4px 8px;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 3;
        overflow: hidden;
    }
    .review-detail-all {
        padding: 12px 8px;
    }
    .review-reviewer {
        width: 100%;
        font-size: $font-s;
        text-align: right;
        color: #666;
    }
</style>