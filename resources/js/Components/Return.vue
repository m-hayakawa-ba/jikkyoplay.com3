<template>

    <Link
        :href="href"
        class="return"
    >
        ◀ 戻る
    </Link>
</template>


<script lang="ts">
import {Link} from "@inertiajs/inertia-vue3";
export default {

    //呼び出し元から渡された引数
    props: [
        "href", //リンク先のurl
    ],

    //読み込んだコンポーネント
    components: {
        Link,
    },

}
</script>



<style lang="scss" scoped>
@import "@/sass/variables";
    .return {
        margin: 12px 8px 0;
        padding: 4px 8px;
        display: inline-block;
        border: solid 1px;
        border-radius: 12px;
        color: #27272a;
        border-color: #626262;
        background-color: #ffffff;
        box-shadow: 1px 1px 1px rgb(60 60 60 / 37%);
        &:hover {
            background-color: #4f70ff;
            border-color: #4f70ff;
            color: #fff;
            transform: scale(1.2);
        }
    }
</style>