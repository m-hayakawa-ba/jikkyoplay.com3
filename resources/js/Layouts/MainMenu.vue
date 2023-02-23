<template>

    <!-- メインウインドウ -->
    <transition name="main-window">
        <div
            v-if="display_flag"
            class="main-window"
        >
            <Link class="menu-link" href="/">
                トップページ
            </Link>
            <Link class="menu-link" href="/">
                ニュース
            </Link>
            <Link class="menu-link" href="/">
                ランキング
            </Link>
            <Link class="menu-link" href="/">
                動画一覧
            </Link>
            <Link class="menu-link" href="/">
                サイトについて
            </Link>
        </div>
    </transition>
</template>


<script>
import { Link } from "@inertiajs/inertia-vue3";
export default {

    //呼び出し元から渡された引数
    props: [
        "display_flag", //表示フラグ
    ],

    //読み込んだコンポーネント
    components: {
        Link,
    },

    //呼び出し元の書き換え
    emits: [
        'set_search_display_flag'
    ],
}
</script>


<style lang="scss" scoped>
@import "@/sass/variables";
    .main-window {
        position: absolute;
        padding: 40px 0;
        width: 100%;
        height: calc(100vh - 100%);
        opacity: 0.95;
        background-color: #292a2a;
        color: #fff;
        text-align: center;
        overflow: scroll;
        @media screen and (min-width: $bp) {
            padding: 80px 0 0;
            overflow: unset;
        }
    }

    //ウインドウ表示アニメーション
    .main-window-enter-from, .main-window-leave-to {
        opacity: 0;
    }
    .main-window-enter-active, .main-window-leave-active {
        transition: opacity 0.2s;
    }
    .main-window-enter-to, .main-window-leave {
        opacity: 0.95;
    }

    .menu-link {
        display: block;
        color: #fff;
    }

</style>