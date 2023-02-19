<template>
    <button type="submit" class="button">
        {{ button_text }}
    </button>
</template>


<script>
export default {

    //呼び出し元から渡された引数
    props: [
        "button_text",
    ],
}
</script>


<style lang="scss" scoped>
@import "@/sass/variables";
    .button {
        display: block;
        margin: 20px auto 0;
        padding: 8px 16px;
        background-color: unset;
        border: solid 2px #6f528f;
        color: #462966;
        font-weight: bold;
        border-radius: 8px;
        cursor: pointer;
        transition:
            background-color 0.3s,
            color 0.3s;
        &:hover{
            background-color: #6f528f;
            color: #fff;
        }
    }
</style>