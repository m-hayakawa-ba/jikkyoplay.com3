<template>
    <div
        @click="goAnker()"
        class="a-link"
    >
        <slot></slot>
    </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
export default defineComponent({

    //呼び出し元から渡された引数
    props: [
        "anker",  //アンカーリンク先のid
    ],

    //メソッド一覧
    methods: {

        //アンカーリンクの場所にスムーススクロールする
        goAnker() {
            if (this.anker) {
                document.getElementById(this.anker)?.scrollIntoView({
                    behavior: "smooth",
                    block: "start",
                    inline: "end"
                });
            }
        }
    },
})
</script>


<style lang="scss" scoped>
@import "@/sass/variables";
    .a-link {
        cursor: pointer;
        user-select: none;
        transition: opacity 0.3s;
        &:hover {
            opacity: 0.8;
        }
    }
</style>