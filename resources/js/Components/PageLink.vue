<template>
    <Link
        :href="href"
        class="link-wrap"
    >
        <div class="link_name">
            {{ link_name }}
        </div>
        <div class="link-arrow">
            <img src="/icon/right.svg">
        </div>
    </Link>
</template>



<script>
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
        margin: 10px 0 0 auto;
    }
    .link-name {

    }
    .link-arrow {
        width: 20px;
        margin-left: 4px;
    }

</style>