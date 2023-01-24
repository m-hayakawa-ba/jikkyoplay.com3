<template>
    <h2>今週の実況動画ランキング</h2>
    <section>
        <div
            v-for="(program, index) in programs"
            class="ranking-wrap"
        >
            <div class="ranking-icon">
                <img src="/image/ranking.webp">
                <div><span>{{ index + 1 }}</span>位</div>
            </div>
            <div class="ranking-view-count">
                <span>{{ program.view_count.toLocaleString() }}</span> 回再生
            </div>
            <Link
                class="program-item"
                :href="'/program/' + program.id"
            >
                <div class="program-image">
                    <img
                        :src="program.image_url"
                        class="program-thumbnail"
                    />
                    <img
                        v-if="program.site_id == constants.site.youtube"
                        src="/image/logo_youtube.webp"
                        class="program-site-icon"
                    >
                    <img
                        v-if="program.site_id == constants.site.nikoniko"
                        src="/image/logo_nikoniko.webp"
                        class="program-site-icon"
                    >
                </div>
                <div class="program-caption">
                    <div class="program-text">
                        {{ program.title }}
                    </div>
                    <div class="creater-data">
                        <div class="creater-icon">
                            <img :src="program.user_icon_url" :alt="program.creater_name">
                        </div>
                        <div class="program-detail">
                            {{ program.creater_name }}<br>
                            {{ format(program.published_at) }} 投稿<br>
                        </div>
                    </div>
                </div>
            </Link>
        </div>

        <!-- ランキング一覧へのリンク -->
        <PageLink
            href="/ranking"
            link_name="すべてのランキング"
        />
    </section>
</template>


<script>
import {usePage, Link} from "@inertiajs/inertia-vue3";
import moment from 'moment';
import PageLink from '../../Components/PageLink.vue';
export default {

    //コンポーネント内で使用する変数
    data() {
        return {
            programs: usePage().props.value.programs,
        };
    },

    //読み込んだコンポーネント
    components: {
        Link,
        PageLink,
    },

    //コンポーネント内で使用するメソッド
    methods: {
        format(date) {
            return moment(date).format('YYYY年M月D日')
        }
    },

    //返り値が固定の関数
    computed: {

        //laravel側から定数を取得する
        constants() {
            return this.$page.props.const;
        },
    },

    //初回読み込み時に実行
    mounted() {
        console.log(this.programs);
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
    .ranking-wrap {
        position: relative;
        margin: 8px 0 0;
        width: 100%;
        @media screen and (min-width: $bp) {
            width: 50%;
        }
    }
    .ranking-icon {
        width: 60px;
        position: absolute;
        top: -8px;
        left: 8px;
        z-index: 1;
        div {
            position: absolute;
            top: 9px;
            left: 50%;
            font-size: $font-l;
            font-weight: bold;
            color: #462107;
            transform: translateX(-50%);
            span {
                font-size: $font-xl;
            }
        }
    }
    .ranking-view-count {
        padding-left: 72px;
        font-weight: bold;
        color: #401409fc;
        span {
            font-size: $font-l;
        }
    }
    .program-item {
        margin: 0 0 6px;
        display: flex;
        flex-wrap: nowrap;
        align-items: center;
        width: 100%;
        cursor: pointer;
        &:hover {
            background-color: #d4f9ff;
            border-radius: 8px;
        }
    }
    .program-image {
        position: relative;
        width: 45%;
        padding: 0 4px 4px 8px;
    }
    .program-thumbnail {
        aspect-ratio: 16 / 9;
        object-fit: cover;
        border-radius: 6px;
        box-shadow: 1px 1px 4px #20060654;
    }
    .program-site-icon {
        position: absolute;
        width: 22%;
        right: 3%;
        bottom: 3%;
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

</style>