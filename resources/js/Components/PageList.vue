<template>
    <div class="page-wrap">

        <!-- 最初のページへ -->
        <Link
            v-if="page_current > 1"
            :href="base_url + '?' + makePageQuery(1)"
            class="page-item"
        >
            <svg fill="currentColor" class="page-svg">
                <use xlink:href="/icon/double_left.svg#double_left"></use>
            </svg>
        </Link>
        <div
            v-else
            class="page-item page-disable"
        >
            <svg fill="currentColor" class="page-svg">
                <use xlink:href="/icon/double_left.svg#double_left"></use>
            </svg>
        </div>

        <!-- 一つ前のページへ -->
        <Link
            v-if="page_current > 1"
            :href="base_url + '?' + makePageQuery(page_current - 1)"
            class="pc-only page-item"
        >
            <svg fill="currentColor" class="page-svg">
                <use xlink:href="/icon/single_left.svg#single_left"></use>
            </svg>
        </Link>
        <div
            v-else
            class="pc-only page-item page-disable"
        >
            <svg fill="currentColor" class="page-svg">
                <use xlink:href="/icon/single_left.svg#single_left"></use>
            </svg>
        </div>

        <!-- ページ数指定 -->
        <template v-for="i of list_num">
            <Link
                v-if="page_current != getPageNumber(i)"
                :href="base_url + '?' + makePageQuery(getPageNumber(i))"
                class="page-item"
            >
                <div class="page-number">
                    {{ getPageNumber(i) }}
                </div>
            </Link>
            <div
                v-else
                :href="base_url + '?' + makePageQuery(getPageNumber(i))"
                class="page-item page-disable"
            >
                <div class="page-number">
                    {{ getPageNumber(i) }}
                </div>
            </div>
        </template>

        <!-- 一つ先のページへ -->
        <Link
            v-if="page_current < page_last"
            :href="base_url + '?' + makePageQuery(page_current + 1)"
            class="pc-only page-item"
        >
            <svg fill="currentColor" class="page-svg">
                <use xlink:href="/icon/single_right.svg#single_right"></use>
            </svg>
        </Link>
        <div
            v-else
            class="pc-only page-item page-disable"
        >
            <svg fill="currentColor" class="page-svg">
                <use xlink:href="/icon/single_right.svg#single_right"></use>
            </svg>
        </div>

        <!-- 最後のページへ -->
        <Link
            v-if="page_current < page_last"
            :href="base_url + '?' + makePageQuery(page_last)"
            class="page-item"
        >
            <svg fill="currentColor" class="page-svg">
                <use xlink:href="/icon/double_right.svg#double_right"></use>
            </svg>
        </Link>
        <div
            v-else
            class="page-item page-disable"
        >
            <svg fill="currentColor" class="page-svg">
                <use xlink:href="/icon/double_right.svg#double_right"></use>
            </svg>
        </div>

    </div>
</template>


<script>
import {Link} from "@inertiajs/inertia-vue3";
export default {

    //呼び出し元から渡された引数
    props: [
        "page_current", //現在のページ番号
        "page_last",    //最後のページ番号
        "base_url",     //クエリストリングを除いたURL
        "queries",      //クエリストリングの配列
    ],

    //読み込んだコンポーネント
    components: {
        Link,
    },

    //コンポーネント内で使用する変数
    data() {
        return {
            list_num: 5,    //1ページ内に表示するページネーションの数。奇数であること。
        };
    },

    //コンポーネント内で使用するメソッド
    methods: {

        //ページネーションのページ番号を作成する
        getPageNumber(number) {
            if (this.page_current <= 3) {
                return number;
            } else if (this.page_current >= this.page_last - 2) {
                return this.page_last - this.list_num + number;
            } else {
                return this.page_current - (this.list_num+1)/2 + number;
            }
        },
        
        //ページ遷移時のクエリ文字列を生成する
        makePageQuery(page) {
            var params = new URLSearchParams(this.queries);
            if (page) {
                params.set('page', page);
            }
            return params.toString();
        },
    },

    //初回読み込み時に実行
    mounted() {
        // console.log(this.page_current);
    }

}
</script>


<style lang="scss" scoped>
@import "@/sass/variables";
    .page-wrap {
        position: sticky;
        bottom: 0;
        display: flex;
        justify-content: center;
    }
    .page-item {
        position: relative;
        width: 42px;
        height: 42px;
        margin: 40px 4px;
        border: solid 2px;
        color: $font-color-link;
        letter-spacing: -2px;
        background-color: #fff;
        box-shadow: 1px 1px 2px #22229980;
        border-radius: 50%;
    }
    .page-disable {
        color: #666;
        background-color: #ccc;
        box-shadow: none;
    }
    .page-svg {
        width: 100%;
        height: 100%;
    }
    .page-number {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: $font-xl;
        font-weight: bold;
    }
</style>