<template>
    <svg
        fill="currentColor"
        class="svg-wrap"
    >
        <use :xlink:href="'/icon/' + icon + '.svg#' + icon"></use>
    </svg>
</template>


<script lang="ts">
import { defineComponent } from "vue";
export default defineComponent({

    //呼び出し元から渡された引数
    props: [
        "icon",
    ],
});
</script>


<style lang="scss" scoped>
    .svg-wrap {
        display: inline;
        width: 100%;
        height: 100%;
    }
</style>