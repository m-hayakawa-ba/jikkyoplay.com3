<template>
    <div class="search-item-wrap">
        <Link class="search-item">
            新着動画
        </Link>
        <Link class="search-item">
            人気の動画
        </Link>
        <Link class="search-item">
            女性実況
        </Link>
        <Link class="search-item">
            RPG
        </Link>
        <Link class="search-item">
            レトロゲーム
        </Link>
        <Link class="search-item">
            その他の動画
        </Link>
        <Link class="search-item">
            その他の動画
        </Link>
        <Link class="search-item">
            その他の動画
        </Link>
        <Link class="search-item">
            詳細検索
        </Link>
    </div>
</template>


<script>
import { Link } from "@inertiajs/inertia-vue3";
export default {

    //読み込んだコンポーネント
    components: {
        Link,
    },

}
</script>


<style lang="scss" scoped>
@import "../../../sass/variables";

    .search-item-wrap {
        margin: 0 auto;
        padding: 12px 0px;
        width: 100%;
        text-align: center;
        white-space: nowrap;
        overflow-x: scroll;
        scrollbar-width: none;
        &::-webkit-scrollbar{
            display:none;
        }
    }
    .search-item {
        margin: 0 8px;
        padding: 4px 8px;
        display: inline-block;
        border: solid 1px;
        border-radius: 12px;
        color: #27272a;
        border-color: #626262;
        background-color: #ffffff;
        box-shadow: 1px 1px 1px #3c3c3c5e;
    }

</style>