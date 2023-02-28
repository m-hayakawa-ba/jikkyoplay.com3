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
            class="review-detail"
            v-html="review.detail"
        ></div>
    </InformationWrap>
</template>


<script>
import ProgramViewCount from "@/js/Components/Program/ProgramViewCount.vue";
import ProgramThumbnail from "@/js/Components/Program/ProgramThumbnail.vue";
import ProgramCaption from "@/js/Components/Program/ProgramCaption.vue";
import InformationWrap from "@/js/Components/Information/InformationWrap.vue";
export default {

    //呼び出し元から渡された引数
    props: [
        "review",
    ],

    //読み込んだコンポーネント
    components: {
        ProgramViewCount,
        ProgramThumbnail,
        ProgramCaption,
        InformationWrap,
    },

}
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
</style>