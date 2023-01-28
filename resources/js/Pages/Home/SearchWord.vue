<template>
    <section>

        <!-- 人気の検索ワード -->
        <a
            v-for="search_word in search_words"
            class="search_word"
        >
            {{ search_word.word }}
        </a>
    </section>
</template>


<script>
import { usePage, Link } from "@inertiajs/inertia-vue3";
export default {

    //コンポーネント内で使用する変数
    data() {
        return {
            search_words: usePage().props.value.search_words,
        };
    },

    //読み込んだコンポーネント
    components: {
        Link,
    },

    //初回読み込み時に実行
    mounted() {
        console.log(this.search_words);
    }

}
</script>


<style lang="scss" scoped>
@import "@/sass/variables";

    section {
        margin: 40px 0 60px;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
    }
    .search_word {
        margin: 6px 2px;
        padding: 4px 6px;
        font-size: $font-m;
        border: solid 1px;
        border-radius: 12px;
        color: #27272a;
        border-color: #626262;
        background-color: #ffffff;
        box-shadow: 1px 1px 1px #3c3c3c5e;
        &:hover {
            background-color: #4f70ff;
            border-color: #4f70ff;
            color: #fff;
            transform: scale(1.2);
        }
        @media screen and (min-width: $bp) {
            margin: 8px 6px;
            padding: 4px 12px;
            font-size: $font-l;
        }
    }

</style>