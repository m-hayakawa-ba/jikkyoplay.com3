<template>
    
    <!-- 上方向へのアンカーリンク -->
    <SmoothLink
        v-if="mode == 'prev' && anker_display"
        :anker="anker_id"
        class="anker-prev"
    >
        <div class="anker-arrow">
            <img
                src="/icon/arrow_up.svg"
                alt="下の項目へのアンカーリンク"
            >
        </div>
        {{ anker_name }}
    </SmoothLink>
    <div
        v-if="mode == 'prev' && !anker_display"
        class="anker-prev anker-display-false"
    >
    </div>

    <!-- 下方向へのアンカーリンク -->
    <SmoothLink
        v-if="mode == 'next' && anker_display"
        :anker="anker_id"
        class="anker-next"
    >
        {{ anker_name }}
        <div class="anker-arrow">
            <img
                src="/icon/arrow_down.svg"
                alt="下の項目へのアンカーリンク"
            >
        </div>
    </SmoothLink>
    <div
        v-if="mode == 'next' && !anker_display"
        class="anker-next anker-display-false"
    >
    </div>
        
</template>


<script lang="ts">
import { AnkerData } from "../Interfaces/AnkerData";
import { defineComponent } from "vue";
import SmoothLink from "@/js/Components/SmoothLink.vue";

export default defineComponent({

    //呼び出し元から渡された引数
    props: {
        anker: {type: Object as () => AnkerData[]},
        mode:  {type: String},
    },

    //読み込んだコンポーネント
    components: {
        SmoothLink,
    },

    //コンポーネント内で使用する変数
    data(): {
        anker_array: AnkerData[]
        anker_name: string
        anker_id: string
        anker_display: boolean
    } {
        return {
            anker_array: [],
            anker_name: '',
            anker_id: '',
            anker_display: true,
        };
    },

    //メソッド一覧
    methods: {

        //各アンカーリンクのスクロール位置を取得する
        getAnkerPosition: function () {
            var pos_y = window.pageYOffset;
            this.anker_array.forEach(e => {
                e.pos = pos_y + document.getElementById(e.id)!.getBoundingClientRect().top
            });
        },

        //アンカーリンクの値を変更する
        setLink: function () {

            //スクロール位置と配列の値を比較する
            this.anker_name = "　";
            this.anker_id = "";
            this.anker_display = false;
            if (this.mode == 'prev') {
                var offset = window.pageYOffset;
                this.anker_array.forEach(e => {
                    if (e.pos < offset) {
                        this.anker_name = e.name;
                        this.anker_id   = e.id;
                        this.anker_display = true;
                    }
                });
            } else if (this.mode == 'next') {
                var offset = window.pageYOffset + 80;
                this.anker_array.some(e => {
                    if (e.pos > offset) {
                        this.anker_name    = e.name;
                        this.anker_id      = e.id;
                        this.anker_display = true;
                        return true;
                    }
                });
            }
        },
    },

    //初回読み込み時に実行
    mounted() {

        //propsを変更可能な変数にセット
        this.anker_array = this.anker!;

        //アンカーリンクの初期値セット
        this.getAnkerPosition();
        this.setLink();

        //スクロールしたらアンカーリンクの値変更
        window.addEventListener("scroll", this.setLink, { passive: true });

        //画面のサイズが変わったら、各項目のスクロール位置を再セット
        window.addEventListener('resize', this.getAnkerPosition, { passive: true });
    }
});
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
    .anker-display-false {
        opacity: 0.40;
    }
    .anker-arrow {
        position: relative;
        margin: 0 auto;
        width: 24px;
    }
</style>