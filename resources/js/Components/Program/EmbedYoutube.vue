<template>

    <div
        class="program-embed-youtube"
    >
        <iframe
            :src="'https://www.youtube.com/embed/' + movie_id"
            frameborder='0'
            allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture'
            allowfullscreen
        ></iframe>
    </div>

</template>

<script>
export default {
    
    //呼び出し元から渡された引数
    props: [
        "movie_id",
    ],
}
</script>


<style lang="scss" scoped>
    .program-embed-youtube {
        position: relative;
        max-width: 100%;
        &::after {
            display: block;
            content: '　';
            width: 100%;
            height: 0;
            padding-top: 60%;
        }
        iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
    }
</style>


