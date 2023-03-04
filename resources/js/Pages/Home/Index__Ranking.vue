<template>

    <!-- ランキング一覧 -->
    <div
        v-for="(ranking, index) in rankings"
        class="ranking-wrap"
    >
        <ProgramWrap
            :rank="index + 1"
            :program="ranking"
        />   
    </div>
</template>


<script>
import {usePage} from "@inertiajs/inertia-vue3";
import ProgramWrap from '@/js/Components/Program/ProgramWrap.vue';
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
        ProgramWrap,
        PageLink,
    },

    //初回読み込み時に実行
    mounted() {
        // console.log();
    }
}
</script>


<style lang="scss" scoped>
@import "@/sass/variables";
    .ranking-wrap {
        position: relative;
        margin: 8px 0 0;
        width: 100%;
        @media screen and (min-width: $bp) {
            width: 49%;
        }
    }

</style>