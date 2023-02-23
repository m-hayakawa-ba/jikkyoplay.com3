<template>

    <!-- メインウインドウ -->
    <transition name="main-window">
        <div
            v-if="display_flag"
            class="main-window"
        >

            <div class="logo-vertical">
                <img src="/image/logo_vertical.png" alt="GameJDM縦ロゴ">
            </div>

            <div class="menu-link" @click="visitLink('/')">
                トップページ
            </div>
            <div class="menu-link" @click="visitLink('/news')">
                ゲーム実況ニュース
            </div>
            <div class="menu-link" @click="visitLink('/ranking')">
                ゲーム実況ランキング
            </div>
            <div class="menu-link" @click="visitLink('/program')">
                ゲーム実況動画一覧
            </div>
            <div class="menu-link" @click="visitLink('/program')">
                ゲーム実況レビュー
            </div>
            <div class="menu-link" @click="visitLink('/history')">
                視聴履歴
            </div>
            <div class="menu-link" @click="visitLink('/about')">
                このサイトについて
            </div>
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
        'set_main_display_flag'
    ],
    
    //コンポーネント内で使う関数
    methods: {

        //別のページヘリダイレクトする
        visitLink(url) {
            this.$inertia.visit(url, {
                onSuccess: () => {
                    this.$emit('set_main_display_flag', false);
                },
            });
        },

    }
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
        cursor: pointer;
        transition: opacity 0.3s;
        &:hover {
            opacity: 0.8;
        }
    }
    .logo-vertical {
        width: 200px;
        margin: 0 auto 40px;
    }

</style>