<template>

    <!-- 新着動画一覧 -->
    <div
        v-for="program in youtube_programs"
        class="program-wrap"
    >
        <ProgramWrap
            :rank="null"
            :program="program"
        />   
    </div>
    <div
        v-for="program in nicovideo_programs"
        class="program-wrap"
    >
        <ProgramWrap
            :rank="null"
            :program="program"
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
            youtube_programs: usePage().props.value.youtube_programs,
            nicovideo_programs: usePage().props.value.nicovideo_programs,
        };
    },

    //読み込んだコンポーネント
    components: {
        ProgramWrap,
        PageLink,
    },

    //初回読み込み時に実行
    mounted() {
        // console.log(this.nicovideo_programs);
    }

}
</script>


<style lang="scss" scoped>
@import "@/sass/variables";
    .program-wrap {
        position: relative;
        margin-bottom: 12px;
        width: 100%;
        @media screen and (min-width: $bp) {
            margin: 0 0.166% 24px;
            width: 33%;
        }
    }

</style>