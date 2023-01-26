<template>
    <h2>おすすめ動画レビュー</h2>
    <section>

        <Link
            v-for="review in reviews"
            :href="'/program/' + review.program_id"
        >
            {{ review.title }}
        </Link>

    </section>
</template>


<script>
import { usePage, Link } from "@inertiajs/inertia-vue3";
export default {

    //コンポーネント内で使用する変数
    data() {
        return {
            reviews: usePage().props.value.reviews,
        };
    },

    //読み込んだコンポーネント
    components: {
        Link,
    },

    //初回読み込み時に実行
    mounted() {
        console.log(this.reviews);
    }
}
</script>


<style lang="scss" scoped>
@import "../../../sass/variables";

    section {
        margin-top: 4px;
        display: flex;
        flex-wrap: wrap;
        @media screen and (min-width: $bp) {
            padding-left: 8px;
        }
    }
</style>