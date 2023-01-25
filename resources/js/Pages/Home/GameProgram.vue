<template>
    <h2>新着実況プレイ動画</h2>
    <section>

        <!-- 新着動画一覧 -->
        <div
            v-for="program in youtube_programs"
            class="program-wrap"
        >
            <ProgramPart
                :rank="null"
                :program="program"
            />   
        </div>
        <div
            v-for="program in nicovideo_programs"
            class="program-wrap"
        >
            <ProgramPart
                :rank="null"
                :program="program"
            />   
        </div>

        <!-- 動画一覧へのリンク -->
        <PageLink
            href="/ranking"
            link_name="すべての動画を見る"
        />

    </section>
</template>

<script>
import {usePage} from "@inertiajs/inertia-vue3";
import ProgramPart from '../../Components/ProgramPart.vue';
import PageLink from '../../Components/PageLink.vue';
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
        ProgramPart,
        PageLink,
    },

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
    .program-wrap {
        position: relative;
        margin: 8px 0 0;
        width: 100%;
        @media screen and (min-width: $bp) {
            width: 50%;
        }
    }

</style>