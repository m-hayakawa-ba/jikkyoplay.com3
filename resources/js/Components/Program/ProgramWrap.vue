<template>

    <!-- 再生回数表示 -->
    <ProgramViewCount
        v-if="rank"
        :rank="rank"
        :view_count="program.view_count"
    />

    <!-- 番組情報 -->
    <Link 
        :href="'/program/' + program.id"
        class="program-wrap"
    >
        <!-- 番組タイトル -->
        <div
            class="program-title"
            v-html="program.title"    
        ></div>

        <!-- 番組サムネイル -->
        <ProgramThumbnail :program="program"/>
    </Link>

</template>


<script lang="ts">
import { defineComponent } from "vue";
import {Link} from "@inertiajs/inertia-vue3";
import ProgramThumbnail from "@/js/Components/Program/ProgramThumbnail.vue";
import ProgramViewCount from "@/js/Components/Program/ProgramViewCount.vue";

export default defineComponent({

    //呼び出し元から渡された引数
    props: [
        "rank",     //ランキングがある場合、何位か（ランキングじゃない場合はnull）
        "program",  //動画情報
    ],

    //読み込んだコンポーネント
    components: {
        Link,
        ProgramThumbnail,
        ProgramViewCount,
    },

    //初回読み込み時に実行
    mounted() {
        // console.log(this.program);
    }
});
</script>


<style lang="scss" scoped>
@import "@/sass/variables";
    .program-wrap {
        width: 100%;
        overflow: hidden;
    }
    .program-title {
        font-weight: bold;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        font-size: $font-m;
        margin: 4px 0;
    }
</style>