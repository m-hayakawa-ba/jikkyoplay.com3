<template>
    
    
    <!-- 上方向へのアンカーリンク -->
    <a
        v-if="mode == 'prev'"
        :href="'#' + anker_id"
        class="anker-prev"
    >
        <div class="anker-arrow">
            <img src="/icon/arrow_up.svg">
        </div>
        {{ anker_name }}
    </a>

    <!-- 下方向へのアンカーリンク -->
    <a
        v-if="mode == 'next'"
        :href="'#' + anker_id"
        class="anker-next"
    >
        {{ anker_name }}
        <div class="anker-arrow">
            <img src="/icon/arrow_down.svg">
        </div>
    </a>
        
</template>


<script>
export default {

    //呼び出し元から渡された引数
    props: [
        "anker",  //画面位置の配列
        "mode",   //"prev" のとき、上へ移動するリンク、"next"のとき、下へ移動するリンク
    ],

    //読み込んだコンポーネント
    components: {
    },

    //コンポーネント内で使用する変数
    data() {
        return {
            anker_array: [],
            anker_name: '',
            anker_id: '',
        };
    },

    //メソッド一覧
    methods: {

        //各アンカーリンクのスクロール位置を取得する
        getAnkerPosition: function () {
            var pos_y = window.pageYOffset;
            this.anker_array.forEach(e => {
                e.pos = pos_y + document.getElementById(e.id).getBoundingClientRect().top
            });
        },

        //アンカーリンクの値を変更する
        setLink: function () {

            //スクロール位置と配列の値を比較する
            if (this.mode == 'prev') {
                var offset = window.pageYOffset;
                this.anker_array.forEach(e => {
                    if (e.pos <= offset) {
                        this.anker_name = e.name;
                        this.anker_id   = e.id;
                    }
                });
            } else if (this.mode == 'next') {
                this.anker_name = "　";
                this.anker_id = "";
                var offset = window.pageYOffset + 64;
                this.anker_array.some(e => {
                    if (e.pos > offset) {
                        this.anker_name = e.name;
                        this.anker_id   = e.id;
                        return true;
                    }
                });
            }
        },
    },

    //初回読み込み時に実行
    mounted() {

        //propsを変更可能な変数にセット
        this.anker_array = this.anker;

        //アンカーリンクの初期値セット
        this.getAnkerPosition();
        this.setLink();

        //スクロールしたらアンカーリンクの値変更
        window.addEventListener("scroll", this.setLink, { passive: true });

        //画面のサイズが変わったら、各項目のスクロール位置を再セット
        window.addEventListener('resize', this.getAnkerPosition, { passive: true });
    }
}
</script>


<style lang="scss" scoped>
@import "@/sass/variables";
    .anker-prev,
    .anker-next {
        position: fixed;
        display: block;
        right: 8px;
        width: 64px;
        height: 48px;
        text-align: center;
        padding: 4px 0;
        border-radius: 8px;
        background-color: #ff49c0;
        color: #fff;
        font-size: $font-s;
        opacity: 0.9;
        box-shadow: 2px 2px 4px rgb(0 0 0 / 25%);
    }
    .anker-prev {
        bottom: 64px;
    }
    .anker-next {
        bottom: 8px;
    }
    .anker-arrow {
        position: relative;
        margin: 0 auto;
        width: 24px;
    }
</style>