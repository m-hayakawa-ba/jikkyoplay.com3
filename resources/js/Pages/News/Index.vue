<template>

    <!-- サイト本体部分 -->
    <div class="inner">
        
        <!-- ゲーム実況ニュース -->
        <H2Title
            :title_jp="format(month) + 'のゲーム実況ニュース'"
            title_en="GAME NEWS"
        />

        <!-- ニュース記事 -->
        <section>

            <!-- 個別のニュース記事 -->
            <NewsWrap
                v-for="news in newses"
                :news="news"
                class="news-wrap"
            />
        </section>

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


<script>
import {usePage, Link} from "@inertiajs/inertia-vue3";
import moment from 'moment';
import H2Title from "@/js/Components/H2Title.vue";
import Return from "@/js/Components/Return.vue";
import NewsWrap from '@/js/Components/News/NewsWrap.vue';
export default {

    //読み込んだコンポーネント
    components: {
        Link,
        H2Title,
        NewsWrap,
        Return,
    },

    //コンポーネント内で使用する変数
    data() {
        return {
            month:  usePage().props.value.month,
            newses: usePage().props.value.newses,
        };
    },

    //コンポーネント内で使用するメソッド
    methods: {
        format(date) {
            return moment(date).format('YYYY年M月')
        },

        //来月の文字列を返す
        //来月がない場合はnullが返る
        nextMonth() {
            if (moment(this.month).format('YYYY-MM') == moment().format('YYYY-MM')) {
                return null;
            } else {
                return moment(this.month).add(1, 'months').format('YYYY-MM');
            }
        },

        //前月の文字列を返す
        //前月がない場合はnullが返る
        prevMonth() {
            return moment(this.month).add(-1, 'months').format('YYYY-MM')
        },
    },

    //初回読み込み時に実行
    mounted() {
        console.log(this.newses);
    },

}
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
    .news-wrap {
        position: relative;
        margin: 8px 0 4px;
        width: 100%;
        @media screen and (min-width: $bp) {
            margin: 8px 0 8px;
            width: 49.5%;
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