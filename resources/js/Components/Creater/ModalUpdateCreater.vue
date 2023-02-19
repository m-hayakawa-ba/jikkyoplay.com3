<template>

    <!-- モーダル表示ボタン -->
    <ButtonOpen
        button_text="実況者情報を修正する"
        @click="display_flag=true"
    />

    <!-- モーダル全体 -->
    <transition>
        <div
            v-if="display_flag"
            class="modal-background-layer"
            v-on:click.self="display_flag=false"
        >
            <!-- モーダル全体 -->
            <div class="modal-wrap">

                <!-- 閉じるボタン -->
                <ButtonClose
                    @click="display_flag=false"
                />

                <!-- モーダルの内容 -->
                <div class="review-description">
                    動画の実況者情報（声）が間違っていた場合、修正することができます。
                </div>

                <!-- フォーム -->
                <form class="review-form" @submit.prevent="submit">

                    <!-- 送信ボタン -->
                    <ButtonSubmit button_text="送信する" />
                </form>
            </div>
        </div>
    </transition>
</template>


<script>
import ButtonOpen from "@/js/Components/Modal/ButtonOpen.vue";
import ButtonClose from "@/js/Components/Modal/ButtonClose.vue";
import ButtonSubmit from "@/js/Components/Modal/ButtonSubmit.vue";
export default {

    //コンポーネント内で使用する変数
    data() {
        return {
            display_flag: false,
        };
    },

    //読み込んだコンポーネント
    components: {
        ButtonOpen,
        ButtonClose,
        ButtonSubmit,
    },

}
</script>


<style lang="scss" scoped>
@import "@/sass/variables";

</style>