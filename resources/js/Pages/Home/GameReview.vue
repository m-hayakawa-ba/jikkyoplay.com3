<template>
    <h2>おすすめ動画レビュー</h2>
    <section>

        <!-- レビュー一覧 -->
        <div
            v-for="review in reviews"
            class="review-wrap"
        >

            <!-- 再生回数表示 -->
            <ProgramViewCount
                :rank="null"
                :view_count="review.view_count"
            />

            <Link
                class="review-item"
                :href="'/program/' + review.program_id"
            >

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
            </Link>
        </div>

        <!-- レビュー一覧へのリンク -->
        <PageLink
            href="/review"
            link_name="すべてのレビューを見る"
        />
    </section>
</template>


<script>
import { usePage, Link } from "@inertiajs/inertia-vue3";
import PageLink from '@/js/Components/PageLink.vue';
import ProgramViewCount from "@/js/Components/ProgramPart/ProgramViewCount.vue";
import ProgramThumbnail from "@/js/Components/ProgramPart/ProgramThumbnail.vue";
import ProgramCaption from "@/js/Components/ProgramPart/ProgramCaption.vue";
export default {

    //コンポーネント内で使用する変数
    data() {
        return {
            reviews: usePage().props.value.reviews,
        };
    },

    //読み込んだコンポーネント
    components: {
        Link,
        PageLink,
        ProgramViewCount,
        ProgramThumbnail,
        ProgramCaption,
    },

    //初回読み込み時に実行
    mounted() {
        console.log(this.reviews);
    }
}
</script>


<style lang="scss" scoped>
@import "@/sass/variables";

    section {
        margin-top: 4px;
        display: flex;
        flex-wrap: wrap;
        @media screen and (min-width: $bp) {
            padding-left: 8px;
        }
    }
    .review-wrap {
        position: relative;
        margin: 8px 0 0;
        width: 100%;
        @media screen and (min-width: $bp) {
            width: 50%;
        }
    }
    .review-item {
        margin: 0 0 6px;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        width: 100%;
        cursor: pointer;
        &:hover {
            background-color: #d4f9ff;
            border-radius: 8px;
        }
    }
    .program-view-count {
        font-weight: bold;
        color: #401409fc;
        span {
            font-size: $font-l;
        }
    }
    .review-detail {
        padding: 4px 8px;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 3;
        overflow: hidden;
    }
</style>