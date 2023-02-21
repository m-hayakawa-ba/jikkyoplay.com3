<template>

    <!-- モーダル全体 -->
    <transition>
        <div
            v-if="display_flag"
            class="modal-background-layer"
            v-on:click.self="setDisplay(false)"
        >
            <!-- モーダル本体 -->
            <div class="modal-wrap">

                <!-- 閉じるボタン -->
                <ButtonClose
                    @click="setDisplay(false)"
                />

                <!-- モーダルの中身 -->
                <slot></slot>

            </div>
        </div>
    </transition>
</template>


<script>
import ButtonClose from "@/js/Components/Modal/ButtonClose.vue";
export default {

    //読み込んだコンポーネント
    components: {
        ButtonClose,
    },

    //呼び出し元から渡された引数
    props: [
        "display_flag",
    ],

    //呼び出し元の書き換え
    emits: [
        'set_display',
    ],

    methods: {

        //親コンポーネントの表示フラグを変更する
        setDisplay(flag) {
            this.$emit('set_display', flag);
        },
    },

}
</script>


<style lang="scss" scoped>
@import "@/sass/variables";
    .modal-background-layer {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        z-index: 10;
        background-color: #0e080880;
        backdrop-filter: blur(2px);
    }
    .modal-wrap {
        background-color: #fff;
        width: 640px;
        max-width: 96%;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        padding: 16px;
        border-radius: 8px;
        box-shadow: 2px 2px 4px #00000020;
    }
    //モーダルの表示アニメーション
    .v-enter-from, .v-leave-to {
        opacity: 0;
    }
    .v-enter-active, .v-leave-active {
        transition: opacity 0.3s;
    }
    .v-enter-to, .v-leave {
        opacity: 1;
    }
</style>