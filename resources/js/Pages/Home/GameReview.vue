<template>
    <h2>おすすめ動画レビュー</h2>
    <section>

        <!-- レビュー一覧 -->
        <div
            v-for="review in reviews"
            class="review-wrap"
        >

            <div
                class="program-view-count"
                style="padding-left: 8px;"
            >
                <span>{{ review.view_count.toLocaleString() }}</span> 回再生
            </div>

            <Link
                class="review-item"
                :href="'/program/' + review.program_id"
            >

                <!-- 番組のサムネイル -->
                <ProgramThumbnail
                    :thumbnail_url="review.image_url"
                    :site_id="review.site_id"
                    class="program_thumbnail"
                />

                <!-- 番組の説明文 -->
                <div class="program-caption">
                    <div class="program-text">
                        {{ review.title }}
                    </div>
                    <div class="creater-data">
                        <div class="creater-icon">
                            <img :src="review.user_icon_url" :alt="review.creater_name">
                        </div>
                        <div class="program-detail">
                            {{ review.creater_name }}<br>
                            {{ format(review.published_at) }} 投稿<br>
                        </div>
                    </div>
                </div>

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
import moment from 'moment';
import PageLink from '../../Components/PageLink.vue';
import ProgramThumbnail from "../../Components/ProgramThumbnail.vue";
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
        ProgramThumbnail,
    },

    //コンポーネント内で使用するメソッド
    methods: {
        format(date) {
            return moment(date).format('YYYY年M月D日')
        }
    },

    //初回読み込み時に実行
    mounted() {
        console.log(this.reviews);
    }
}
</script>


<style lang="scss" scoped>
@import "../../../sass/variables";

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
    .program_thumbnail {
        width: 45%;
    }
    .program-caption {
        width: 55%;
        padding: 4px 6px 4px 2px;
    }
    .program-text {
        font-weight: bold;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        overflow: hidden;
    }
    .creater-data {
        display: flex;
        align-items: center;
    }
    .creater-icon {
        width: 38px;
        border-radius: 50%;
        overflow: hidden;
        span {
            width: 58px;
        }
    }
    .program-detail {
        margin-left: 8px;
        font-size: $font-s;
    }
    .review-detail {
        padding: 4px 8px;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 3;
        overflow: hidden;
    }
</style>