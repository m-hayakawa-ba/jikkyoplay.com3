<template>
    <header>
        <div class="header-wrap">

            <!-- サイトロゴ -->
            <h1 class="header-logo">
                <Link href="/">
                    <img src="/image/logo.png" :alt="constants.site_title">
                </Link>
            </h1>

            <!-- 検索マーク -->
            <div class="header-search">
                <transition name="search-icon">
                    <div
                        v-if="!search_display_flag"
                        class="header-icon"
                        @click="search_display_flag=true"
                    >
                        <SvgIcon icon="search" />
                    </div>
                </transition>
                <transition name="search-icon">
                    <div
                        v-if="search_display_flag"
                        class="header-icon"
                        @click="search_display_flag=false"
                    >
                        <SvgIcon icon="cross" />
                    </div>
                </transition>
            </div>

            <!-- ドロワーメニュー -->
            <div class="header-hamburger">
                <img src="/icon/hamburger.svg" alt="ハンバーガーアイコン">
            </div>

        </div>

        <!-- 検索ウインドウ -->
        <SearchMenu
            :display_flag="search_display_flag"
        />

    </header>

</template>


<script>
import { Link } from "@inertiajs/inertia-vue3";
import SvgIcon from "@/js/Components/SvgIcon.vue";
import SearchMenu from "@/js/Layouts/SearchMenu.vue";
export default {

    //読み込んだコンポーネント
    components: {
        Link,
        SvgIcon,
        SearchMenu,
    },

    //コンポーネント内で使用する変数
    data() {
        return {
            search_display_flag: false, //検索ウインドウの表示フラグ
        };
    },

    //返り値が固定の関数
    computed: {

        //laravel側から定数を取得する
        constants() {
            return this.$page.props.const;
        },
    }
}
</script>


<style lang="scss" scoped>
@import "../../sass/variables";

    header {
        position: sticky;
        top: 0;
        width: 100%;
        height: min-content;
        background-color: #ffffffe0;
        z-index: 10;
        border-bottom: solid 1px #ddd;
        box-shadow: 0px 0px 4px #00000020;
        user-select: none;
    }
    .header-wrap {
        display: grid;
        align-items: center;
        grid-template-columns: auto 40px 40px;
        max-width: $pc-width;
        margin: 0 auto;
        padding: 8px 12px;
    }

    .header-logo {
        width: 168px;
    }
    .header-search {
        position: relative;
        width: 100%;
        height: 100%;
        margin: 0 0 0 auto;
        color: #333;
        cursor: pointer;
        @media screen and (min-width: $bp) {
            transition: opacity 0.3s;
            &:hover {
                opacity: 0.8;
            }
        }
        .header-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 28px;
            height: 28px;
        }
    }
    
    .header-hamburger {
        width: 24px;
        margin: 0 0 0 auto;
    }
    .search-icon-enter-from, .search-icon-leave-to {
        opacity: 0;
    }
    .search-icon-enter-active, .search-icon-leave-active {
        transition: opacity 0.2s;
    }
    .search-icon-enter-to, .search-icon-leave {
        opacity: 1;
    }

</style>