<template>
    <Link
        :href="href"
        class="link-wrap"
    >
        <div class="link-name">
            {{ link_name }}
        </div>
        <svg fill="currentColor" class="link-arrow">
            <use xlink:href="/icon/right.svg#right" />
        </svg>
    </Link>
</template>



<script lang="ts">
import { Link } from "@inertiajs/inertia-vue3";
export default {

    //呼び出し元から渡された引数
    props: [
        "href",      //リンク先のurl
        "link_name", //リンク名
    ],

    //読み込んだコンポーネント
    components: {
        Link,
    },

}
</script>


<style lang="scss" scoped>
@import "../../sass/variables";

    .link-wrap {
        display: flex;
        justify-content: flex-end;
        margin: 2px 0 0 auto;
    }
    .link-name {
        color: $font-color-link;
        font-weight: bold;
    }
    .link-arrow {
        width: 20px;
        height: 20px;
        margin-left: 4px;
        color: $font-color-link;
    }

</style>