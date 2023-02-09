<template>

    <!-- サイト本体部分 -->
    <div class="inner">
        
        <!-- 今週のランキング -->
        <H2Title
            title_jp="ゲーム実況動画一覧"
            title_en="GAMEPLAY PROGRAMS"
        />

        <section>

            <!-- 動画一覧 -->
            <div
                v-for="program in programs"
                class="program-wrap"
            >
                <ProgramWrap
                    :rank="null"
                    :program="program"
                />   
            </div>
        </section>
    </div>
</template>


<script>
import {usePage} from "@inertiajs/inertia-vue3";
import H2Title from "@/js/Components/H2Title.vue";
import ProgramWrap from '@/js/Components/Program/ProgramWrap.vue';
export default {

    //読み込んだコンポーネント
    components: {
        H2Title,
        ProgramWrap,
    },

    //コンポーネント内で使用する変数
    data() {
        return {
            programs: usePage().props.value.programs,
        };
    },
    
}
</script>


<style lang="scss" scoped>
@import "@/sass/variables";
    section {
        margin-top: 4px;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        @media screen and (min-width: $bp) {
            padding-left: 8px;
        }
    }
    .program-wrap {
        position: relative;
        margin: 8px 0 0;
        width: 100%;
        @media screen and (min-width: $bp) {
            width: 49%;
        }
    }
</style>