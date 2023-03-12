<template>
    <div class="view-count-wrap">

        <!-- ランキング表示 -->
        <div
            class="ranking-icon"
        >
            <img src="/image/ranking.webp" :alt="`ランキング 第${rank}位`">
            <div><span>{{ rank }}</span>位</div>
        </div>
    </div>
</template>


<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({

    //呼び出し元から渡された引数
    props: [
        "rank",       //再生回数が何位か（表示しない場合はnull）
        "view_count", //再生回数
    ],

});
</script>


<style lang="scss" scoped>
@import "@/sass/variables";
    .view-count-wrap {
        width: 100%;
        position: relative;
    }
    .ranking-icon {
        width: 72px;
        position: absolute;
        top: 26px;
        left: -6px;
        z-index: 1;
        div {
            position: absolute;
            top: 13px;
            left: 52%;
            font-size: $font-l;
            font-weight: bold;
            white-space: nowrap;
            color: #462107;
            transform: translateX(-50%);
            span {
                font-size: $font-xl;
            }
        }
    }
</style>