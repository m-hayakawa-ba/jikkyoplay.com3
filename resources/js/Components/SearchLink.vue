<template>
    <Link
        :href="'/program?' + query"
        class="search-link"
    >
        {{ name }}
        <span><SvgIcon icon="single_right" /></span>
    </Link>
</template>

<script>
import {Link} from "@inertiajs/inertia-vue3";
import SvgIcon from "@/js/Components/SvgIcon.vue";
export default {

    //呼び出し元から渡された引数
    props: [
        "name",     //リンク名
        "query",    //検索クエリ
    ],

    //読み込んだコンポーネント
    components: {
        SvgIcon,
        Link,
    },

}
</script>


<style lang="scss" scoped>
@import "@/sass/variables";
    .search-link {
        display: inline-block;
        padding: 3px 6px 3px 10px;
        border: solid 1px;
        border-radius: 10px;
        font-weight: bold;
        color: $font-color-link;
        span {
            display: inline-block;
            height: 16px;
            width: 16px;
            position: relative;
            top: 3px;
        }
    }
</style>