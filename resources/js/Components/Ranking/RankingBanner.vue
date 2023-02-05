<template>
    <div class="banner-wrap">
        <div class="banner-image">
            <img :src="image_url" :alt="title">
        </div>
        <div class="banner-title">
            {{ title }}
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
        position: relative;
        border-radius: 4px;
        overflow: hidden;
    }
    .banner-image {

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