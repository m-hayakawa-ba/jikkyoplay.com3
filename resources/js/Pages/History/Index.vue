<template>

    <!-- タイトル -->
    <Head>
        <title>視聴履歴｜ゲーム実況動画まとめサイト GameJDM</title>
    </Head>

    <!-- サイト本体部分 -->
    <div class="inner">
        
        <!-- 視聴履歴 -->
        <H2Title
            title_jp="視聴履歴"
            title_en="WATCH HISTORY"
        />

        <!-- 動画一覧 -->
        <section>
            <div
                v-for="program in programs"
                :key="program.id"
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


<script lang="ts">
import { defineComponent } from "vue";

import { SimpleProgram } from "../../Interfaces/Program";

import H2Title from "@/js/Components/H2Title.vue";
import { Head, usePage } from "@inertiajs/inertia-vue3";
import ProgramWrap from '@/js/Components/Program/ProgramWrap.vue';

export default defineComponent({

    //コンポーネント内で使用する変数
    data(): {
        programs: SimpleProgram[];
    } {
        return {
            programs: usePage().props.value.programs as SimpleProgram[],
        };
    },

    //読み込んだコンポーネント
    components: {
        H2Title,
        ProgramWrap,
    },

    mounted() {
        console.log(this.programs);
    },
});
</script>


<style lang="scss" scoped>
@import "@/sass/variables";
    section {
        margin-top: 4px;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        @media screen and (min-width: $bp) {
            padding-left: 8px;
        }
    }
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