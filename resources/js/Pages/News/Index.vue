<template>

    <!-- タイトル -->
    <Head>
        <title>{{ format(month) }}のゲーム実況ニュース｜ゲーム実況動画まとめサイト GameJDM</title>
        <meta name="description" :content="'ゲームの実況プレイに関するニュースをまとめています。' + format(month) + 'のゲーム実況ニュース一覧です。'" />
        <link rel="canonical" :href="'https://jikkyoplay.com/news/' + thisMonth()">
    </Head>

    <!-- サイト本体部分 -->
    <div class="inner">
        
        <!-- ゲーム実況ニュース -->
        <H2Title
            :title_jp="format(month) + 'のゲーム実況ニュース'"
            title_en="GAME NEWS"
        />

        <!-- ニュース記事 -->
        <DefaultSection>
            <div
                v-for="news in newses"
                :key="news.id"
                class="news-wrap"
            >
                <NewsWrap :news="news"/>
            </div>
        </DefaultSection>

        <!-- 来月と前月へのリンク -->
        <div class="other-month-wrap">

            <!-- 来月（未来）へのリンク -->
            <Link
                v-if="nextMonth()"
                :href="'/news/' + nextMonth()"
                class="other-month"
            >
                <svg fill="currentColor" class="link-arrow">
                    <use xlink:href="/icon/left.svg#left" />
                </svg>
                <div>
                    &nbsp;{{ format(nextMonth()) }} のニュース
                </div>
            </Link>
            <div
                v-else
                class="no-link"
            >
                <svg fill="currentColor" class="link-arrow">
                    <use xlink:href="/icon/left.svg#left" />
                </svg>
                <div>
                    ニュースはありません
                </div>
            </div>

            <!-- 前月（過去）へのリンク -->
            <Link
                v-if="prevMonth()"
                :href="'/news/' + prevMonth()"
                class="other-month"
            >
                <div>
                    {{ format(prevMonth()) }} のニュース&nbsp;
                </div>
                <svg fill="currentColor" class="link-arrow">
                    <use xlink:href="/icon/right.svg#right" />
                </svg>
            </Link>
        </div>
    </div>
</template>


<script lang="ts">
import { defineComponent } from "vue";
import { News } from "../../Interfaces/News";
import { Head, usePage, Link } from "@inertiajs/inertia-vue3";
import moment from 'moment';
import H2Title from "@/js/Components/H2Title.vue";
import NewsWrap from '@/js/Components/News/NewsWrap.vue';
import Return from "@/js/Components/Return.vue";
import DefaultSection from "@/js/Components/Section/DefaultSection.vue";

export default defineComponent({

    //読み込んだコンポーネント
    components: {
        Head,
        Link,
        H2Title,
        NewsWrap,
        Return,
        DefaultSection,
    },

    //コンポーネント内で使用する変数
    data(): {
        month:  string,
        newses: News[],
    } {
        return {
            month:  usePage().props.value.month as string,
            newses: usePage().props.value.newses as News[],
        };
    },

    //コンポーネント内で使用するメソッド
    methods: {
        format(date: string) {
            return moment(date).format('YYYY年M月')
        },

        thisMonth(): string {
            return moment(this.month).format('YYYY-MM')
        },

        //来月の文字列を返す
        //来月がない場合は空文字列が返る
        nextMonth(): string {
            if (moment(this.month).format('YYYY-MM') == moment().format('YYYY-MM')) {
                return '';
            } else {
                return moment(this.month).add(1, 'months').format('YYYY-MM');
            }
        },

        //前月の文字列を返す
        //前月がない場合は空文字列が返る
        prevMonth(): string {
            return moment(this.month).add(-1, 'months').format('YYYY-MM')
        },
    },

    //初回読み込み時に実行
    mounted() {
        // console.log(this.newses);
    },

});
</script>


<style lang="scss" scoped>
@import "@/sass/variables";
    .news-wrap {
        position: relative;
        margin: 8px 0 0;
        width: 100%;
        @media screen and (min-width: $bp) {
            margin: 0 0.5% 24px;
            width: 49%;
        }
    }
    .other-month-wrap {
        display: flex;
        width: 100%;
        overflow: hidden;
        flex-wrap: nowrap;
        margin: 30px 0 40px;
        justify-content: space-around;
        @media screen and (min-width: $bp) {
            font-size: $font-l;
            justify-content: center;
        }
    }
    .other-month, .no-link {
        margin: 12px 2px;
        display: flex;
        white-space: nowrap;
        font-weight: bold;
        color: $font-color-link;
        @media screen and (min-width: $bp) {
            margin: 12px;
        }
    }
    .no-link {
        color: #888;
    }
    .link-arrow {
        width:  20px;
        height: 20px;
        @media screen and (min-width: $bp) {
            width:  24px;
            height: 24px;
        }
    }
</style>