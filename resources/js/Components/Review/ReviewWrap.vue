<template>

    <!-- 番組情報 -->
    <Link 
        :href="'/program/' + review.id"
        class="review-wrap"
    >
        <!-- 番組タイトル -->
        <div class="review-title">
            {{ review.title }}
        </div>

        <!-- 全体のflex -->
        <div class="review-flex">

            <!-- 番組サムネイル -->
            <div class="review-thumbnail">
                <ProgramThumbnail :program="review"/>
            </div>

            <!-- レビュー本文とレビュワー名 -->
            <div class="review-text">

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
            </div>
        </div>
    </Link>
</template>


<script lang="ts">
import { defineComponent } from "vue";
import {Link} from "@inertiajs/inertia-vue3";
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
        Link,
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
    .review-wrap {
        display: block;
        margin-bottom: 20px;
        width: 100%;
        overflow: hidden;
    }
    .review-title {
        font-weight: bold;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-size: $font-m;
        margin: 4px 0;
    }
    .review-flex {
        display: flex;
        flex-wrap: wrap;
        .review-thumbnail {
            width: 100%;
            @media screen and (min-width: $bp) {
                width: 33%;
            }
        }
        .review-text {
            width: 100%;
            @media screen and (min-width: $bp) {
                width: 67%;
            }
        }
    }
    .review-detail {
        height: 70px;
        padding: 4px 8px;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 3;
        overflow: hidden;
    }
    .review-detail-all {
        margin: 4px 0 0 0;
        overflow: hidden;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 7;
        @media screen and (min-width: $bp) {
            margin: 12px 0 0 8px;
        }
    }
    .review-reviewer {
        width: 100%;
        font-size: $font-s;
        text-align: right;
        color: #666;
    }
</style>