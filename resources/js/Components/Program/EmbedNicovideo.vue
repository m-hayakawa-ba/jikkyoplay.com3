<template>

    <div
        class="program-embed-nicovideo"
    >
        <div
            id="js-program-embed"
            class="program-embed-nicovideo-ratio"
        ></div>
    </div>

</template>

<script>
export default {
    
    //呼び出し元から渡された引数
    props: [
        "movie_id",
    ],

    //初回読み込み時に実行
    mounted() {

        let target, script
        document.write = function (arg) {
            target.innerHTML = arg;
            document.write = write;
        };
        script = document.createElement('script');
        script.setAttribute('type', 'text/javascript');
        script.setAttribute('src', 'https://ext.nicovideo.jp/thumb_watch/' + this.movie_id);
        target = document.getElementById('js-program-embed');
        target.appendChild(script);
    }
}
</script>


<style lang="scss">
//ニコ動の埋め込みで、scopedが使えなかった
    .program-embed-nicovideo {
        position: relative;
        max-width: 100%;
        .program-embed-nicovideo-ratio {
            display: block;
            width: 100%;
            height: 0;
            padding-top: 60%;
        }
        iframe {
            max-width: 100%;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
    }
</style>