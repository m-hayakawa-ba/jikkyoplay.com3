<template>

    <!-- モーダル表示ボタン -->
    <div
        class="edit-button"
        @click="display_flag = true"
    >
        <SvgIcon icon="edit" class="icon" />
    </div>

    <!-- 編集モーダル -->
    <ModalWrap
        :display_flag="display_flag"
        @set_display="setDisplay"
    >

        <!-- モーダルの内容 -->
        <div class="review-description">
            動画のゲーム情報が間違っていた場合、修正することができます。
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
import SvgIcon from "@/js/Components/SvgIcon.vue";
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
        SvgIcon,
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
    .edit-button {
        position: absolute;
        bottom: 0;
        right: 2px;
        padding: 4px 8px;
        width: 36px;
        height: 36px;
        text-align: center;
        cursor: pointer;
        transition: opacity 0.3s;
        &:hover {
            opacity: 0.8;
        }
    }
</style>