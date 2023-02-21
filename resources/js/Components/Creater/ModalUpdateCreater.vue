<template>

    <!-- モーダル表示ボタン -->
    <ButtonOpen
        button_text="実況者情報を修正する"
        @click="display_flag=true"
    />

    <!-- 編集モーダル -->
    <ModalWrap
        :display_flag="display_flag"
        @set_display="setDisplay"
    >

        <!-- モーダルの内容 -->
        <div class="review-description">
            動画の実況者情報（声）が間違っていた場合、修正することができます。
        </div>

        <!-- フォーム -->
        <form class="review-form" @submit.prevent="submit">

            <!-- 送信ボタン -->
            <ButtonSubmit button_text="送信する" />
            
        </form>
    </ModalWrap>
</template>


<script>
import ModalWrap from "@/js/Components/Modal/ModalWrap.vue";
import ButtonOpen from "@/js/Components/Modal/ButtonOpen.vue";
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
        ModalWrap,
        ButtonOpen,
        ButtonSubmit,
    },

    //コンポーネント内で使う関数
    methods: {

        //モーダルの表示非表示の切り替え
        setDisplay(flag) {
            this.display_flag = flag;
        },
    }

}
</script>


<style lang="scss" scoped>
@import "@/sass/variables";

</style>