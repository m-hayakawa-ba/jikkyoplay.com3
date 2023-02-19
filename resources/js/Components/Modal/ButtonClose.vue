<template>
    <div class="button">
        <SvgIcon icon="cross" />
    </div>
</template>


<script>
import SvgIcon from "@/js/Components/SvgIcon.vue";
export default {

    //読み込んだコンポーネント
    components: {
        SvgIcon,
    },

}
</script>


<style lang="scss" scoped>
@import "@/sass/variables";
    .button {
        position: absolute;
        top: -36px;
        right: 0px;
        width: 30px;
        height: 30px;
        color: #fff;
        cursor: pointer;
        transition: opacity 0.3s;
        &:hover {
            opacity: 0.8;
        }
    }
</style>