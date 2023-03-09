<template>
    <Link
        :href="link"
        class="search-tag"
    >
        {{ name }}
        <span>
            <SvgIcon :icon="icon"/>
        </span>
    </Link>
</template>

<script lang="ts">
import {Link} from "@inertiajs/inertia-vue3";
import SvgIcon from "@/js/Components/SvgIcon.vue";
export default {

    //呼び出し元から渡された引数
    props: [
        "name",    //リンク名
        "link",    //リンク先
        "icon",    //リンクアイコン
    ],

    //読み込んだコンポーネント
    components: {
        Link,
        SvgIcon,
    },

}
</script>


<style lang="scss" scoped>
@import "@/sass/variables";
    .search-tag {
        margin: 6px 8px;
        padding: 4px 8px;
        display: inline-block;
        border: solid 1px;
        border-radius: 12px;
        color: #27272a;
        border-color: #626262;
        background-color: #ffffff;
        box-shadow: 1px 1px 1px #3c3c3c5e;
        span {
            display: inline-block;
            width: 14px;
            height: 14px;
            position: relative;
            top: 2px;
            padding-left: 2px;
        }
    }
</style>