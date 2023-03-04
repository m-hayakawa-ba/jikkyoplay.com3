<template>
    <div class="search-item-wrap">
        <Link
            v-for="recommend_query in recommend_queries"
            :key="recommend_query.id"
            :href="recommend_query.path"
            class="search-item"
        >
            {{ recommend_query.name }}
        </Link>
    </div>
</template>


<script lang="ts">
import { RecommendQuery } from '../../Interfaces/RecommendQuery'
import { usePage } from "@inertiajs/inertia-vue3";
import { Link } from "@inertiajs/inertia-vue3";
import { defineComponent } from "vue";

export default defineComponent({

    //コンポーネント内で使用する変数
    data(): {
        recommend_queries: RecommendQuery[]
    } { return {
        recommend_queries: usePage().props.value.recommend_queries as RecommendQuery[],
    }},

    //読み込んだコンポーネント
    components: {
        Link,
    },
});
</script>


<style lang="scss" scoped>
@import "../../../sass/variables";

    .search-item-wrap {
        margin: 0 auto;
        padding: 16px 0px;
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
        &:hover {
            background-color: #4f70ff;
            border-color: #4f70ff;
            color: #fff;
            transform: scale(1.2);
        }
    }

</style>