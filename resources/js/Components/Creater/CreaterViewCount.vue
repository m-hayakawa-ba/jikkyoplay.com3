<template>
    <div class="view-count-wrap">

        <!-- ランキング表示 -->
        <div
            v-if="rank"
            class="ranking-icon"
        >
            <img src="/image/ranking.webp">
            <div><span>{{ rank }}</span>位</div>
        </div>

        <!-- 再生回数 -->
        <div
            v-if="rank"
            class="view-count"
            style="padding-left: 72px;"
        >
            <span>合計 {{ Number(view_count).toLocaleString() }}</span> 回再生
        </div>
        <div
            v-else
            class="view-count"
            style="padding-left: 8px;"
        >
            <span>合計 {{ Number(view_count).toLocaleString() }}</span> 回再生
        </div>
    </div>
</template>


<script>
export default {

    //呼び出し元から渡された引数
    props: [
        "rank",       //再生回数が何位か（表示しない場合はnull）
        "view_count", //再生回数
    ],
}
</script>


<style lang="scss" scoped>
@import "@/sass/variables";
    .view-count-wrap {
        width: 100%;
        position: relative;
    }
    .ranking-icon {
        width: 60px;
        position: absolute;
        top: -8px;
        left: 8px;
        z-index: 1;
        div {
            position: absolute;
            top: 9px;
            left: 50%;
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
    .view-count {
        position: relative;
        top: 2px;
        font-weight: bold;
        color: #401409fc;
        span {
            font-size: $font-l;
        }
    }
</style>