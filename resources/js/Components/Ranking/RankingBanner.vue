<template>
    <div class="banner-wrap">
        <div class="banner-retio">
            <div class="banner-image">
                <img :src="image_url" :alt="title">
            </div>
            <div class="banner-title">
                {{ title }}
            </div>
        </div>
    </div>
</template>


<script>
export default {

    //呼び出し元から渡された引数
    props: [
        "image_url",
        "title",
    ],

}
</script>


<style lang="scss" scoped>
@import "@/sass/variables";
    .banner-wrap {
        padding-top: 68px;
        margin-top: -68px;
    }
    .banner-retio {
        position: relative;
        left: -8px;
        width: calc(100% + 16px);
        margin-bottom: 20px;
        overflow: hidden;
        @media screen and (min-width: $bp) {
            left: 0;
            width: 100%;
            border-radius: 4px;
        }
    }
    .banner-image {
        padding-top: calc(100% / 16 * 5);
        height: 0;
        overflow: hidden;
        img {
            position: absolute;
            top: 0;
        }
    }
    .banner-title {
        width: 100%;
        padding: 0;
        background-color: #220000;
        text-align: center;
        color: #fff;
        font-size: $font-l;
        @media screen and (min-width: $bp) {
            padding: 8px 0;
            background-color: #220000b0;
            position: absolute;
            bottom: 0;
            letter-spacing: 2px;
            font-size: $font-xl;
        }
    }
</style>