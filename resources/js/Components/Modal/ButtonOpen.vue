<template>
    <div class="button">
        {{ button_text }}
        <SvgIcon icon="edit" class="icon" />
    </div>
</template>


<script>
import SvgIcon from "@/js/Components/SvgIcon.vue";
export default {

    //呼び出し元から渡された引数
    props: [
        "button_text",
    ],

    //読み込んだコンポーネント
    components: {
        SvgIcon,
    },

}
</script>


<style lang="scss" scoped>
@import "@/sass/variables";
    .button {
        width: fit-content;
        margin: 0 0 0 auto;
        padding: 2px 12px 4px;
        border: solid 1px #8b9699;
        border-radius: 4px;
        text-align: center;
        cursor: pointer;
        transition: opacity 0.3s;
        &:hover {
            opacity: 0.8;
        }
    }
    .icon {
        position: relative;
        top: 4px;
        width: 20px;
        height: 20px;
    }
</style>