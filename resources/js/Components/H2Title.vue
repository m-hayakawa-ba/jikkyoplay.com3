<template>
    <h2>
        <div class="h2-title-en">{{ title_en }}</div>
        <div>　</div>
        <div class="h2-title-ja">{{ title_jp }}</div>
    </h2>
</template>

<script lang="ts">
export default {

    //呼び出し元から渡された引数
    props: [
        "title_jp",
        "title_en",
    ],
}
</script>


<style lang="scss" scoped>
@import "../../sass/variables";
    h2 {
        position: relative;
        margin-top: 20px;
        padding: 4px;
        display: block;
        border-left: solid 4px #ff49c0;
        background-color: #fff;
        overflow: hidden;
    }
    .h2-title-en {
        position: absolute;
        top: 5px;
        left: 0;
        font-size: 42px;
        white-space: nowrap;
        transform: skewX(-45deg);
        color: #ffdff4;
        user-select: none;
    }
    .h2-title-ja {
        position: absolute;
        top: 5px;
        left: 6px;
        font-size: $font-xl;
        text-shadow: 0 0 2px #fff;
    }
</style>