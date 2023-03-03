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

            <div class="main-contents">
                <div class="menu-link" @click="visitLink('/')">
                    トップページ
                </div>
                <div class="menu-link" @click="visitLink('/news')">
                    ゲーム実況ニュース
                </div>
                <div class="menu-link" @click="visitLink('/ranking')">
                    実況動画ランキング
                </div>
                <div class="menu-link" @click="visitLink('/program')">
                    ゲーム実況動画一覧
                </div>
                <div class="menu-link" @click="visitLink('/review')">
                    おすすめ動画レビュー
                </div>
            </div>

            <div class="sub-contents">
                <div class="menu-link" @click="visitLink('/history')">
                    視聴履歴
                </div>
                <div class="menu-link" @click="visitLink('/about')">
                    このサイトについて
                </div>
                <a class="menu-link" :href="constants.url.official_twitter" target="_blank">
                    Twitter
                </a>
            </div>
        </div>
    </transition>
</template>


<script lang="ts">
import { defineComponent } from "vue";
import { Link } from "@inertiajs/inertia-vue3";
export default defineComponent({

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

    //返り値が固定の関数
    computed: {

        //laravel側から定数を取得する
        constants() {
            return this.$page.props.const;
        },
    },
    
    //コンポーネント内で使う関数
    methods: {

        //別のページヘリダイレクトする
        visitLink(url: string) {
            this.$inertia.visit(url, {
                onSuccess: () => {
                    this.$emit('set_main_display_flag', false);
                },
            });
        },

    }
});
</script>


<style lang="scss" scoped>
@import "@/sass/variables";
    .main-window {
        position: absolute;
        top: 0;
        padding: 96px 0 80px;
        width: 100%;
        height: 100vh;
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
    .main-contents {
        font-size: $font-l;
        margin: 8px 0;
    }
    .sub-contents {
        margin: 20px 0 0;
    }
    .menu-link {
        display: block;
        color: #fff;
        margin: 8px 0;
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