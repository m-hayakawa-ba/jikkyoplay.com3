<template>
    <h2>今週の実況動画ランキング</h2>
    <section>

        <!-- ランキング一覧 -->
        <div
            v-for="(ranking, index) in rankings"
            class="ranking-wrap"
        >
            <ProgramPart
                :rank="index + 1"
                :program="ranking"
            />   
        </div>

        <!-- ランキング一覧へのリンク -->
        <PageLink
            href="/ranking"
            link_name="すべてのランキング"
        />
    </section>
</template>


<script>
import {usePage} from "@inertiajs/inertia-vue3";
import ProgramPart from '@/js/Components/ProgramPart/ProgramWrap.vue';
import PageLink from '@/js/Components/PageLink.vue';
export default {

    //コンポーネント内で使用する変数
    data() {
        return {
            rankings: usePage().props.value.rankings,
        };
    },

    //読み込んだコンポーネント
    components: {
        ProgramPart,
        PageLink,
    },

    //初回読み込み時に実行
    mounted() {
    }
}
</script>


<style lang="scss" scoped>
@import "@/sass/variables";

    section {
        margin-top: 4px;
        display: flex;
        flex-wrap: wrap;
        @media screen and (min-width: $bp) {
            padding-left: 8px;
        }
    }
    .ranking-wrap {
        position: relative;
        margin: 8px 0 0;
        width: 100%;
        @media screen and (min-width: $bp) {
            width: 50%;
        }
    }

</style>