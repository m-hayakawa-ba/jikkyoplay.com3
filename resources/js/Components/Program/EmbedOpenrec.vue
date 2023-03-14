<template>

    <div
        class="program-embed-openrec"
    >
        <a
            :href="`https://www.openrec.tv/movie/${movie_id}`"
            class="program-embed-openrec-ratio"
        >
            <img :src="image_url" :alt="title">
        </a>
    </div>
</template>


<script>
export default {
    
    //呼び出し元から渡された引数
    props: [
        "movie_id",
        "title",
        "image_url",
    ],
}
</script>


<style lang="scss" scoped>
.program-embed-openrec {
    position: relative;
    max-width: 100%;
    .program-embed-openrec-ratio {
        display: block;
        width: 100%;
        height: 0;
        padding-top: 60%;
    }
    img {
        max-width: 100%;
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
}
</style>