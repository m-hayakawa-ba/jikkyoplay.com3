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
        <div class="program-description">
            動画の音声情報が間違っていた場合、修正することができます。
        </div>

        <!-- フォーム -->
        <form class="program-form" @submit.prevent="submit">

            <!-- 実況者の声 -->
            <div class="program-form-item">
                <label for="voice_id">実況者の音声情報</label>
                <select
                    id="voice_id"
                    required
                    v-model="voice_id"
                >
                    <option
                        v-for="voice in list_voices"
                        :key="voice.id"
                        :value="voice.id"
                    >{{ voice.type }}</option>
                </select>
            </div>

            <!-- エラーメッセージ -->
            <ul v-for="error in errors" class="error-message">
                <li>
                    {{ error }}
                </li>
            </ul>

            <!-- 送信ボタン -->
            <ButtonSubmit button_text="修正する" />
            
        </form>
    </ModalWrap>
</template>


<script>
import { usePage }  from "@inertiajs/inertia-vue3";
import ModalWrap    from "@/js/Components/Modal/ModalWrap.vue";
import SvgIcon      from "@/js/Components/SvgIcon.vue";
import ButtonSubmit from "@/js/Components/Modal/ButtonSubmit.vue";
export default {

    //呼び出し元から渡された引数
    props: [
        "program_id",
        "default_voice_id",
    ],

    //呼び出し元の書き換え
    emits: [
        'change_voice_id'
    ],

    //コンポーネント内で使用する変数
    data() {
        return {
            display_flag: false,
            voice_id: this.default_voice_id,
            list_voices: usePage().props.value.list_voices,
            errors: [],
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
        
        //フォームの送信
        submit() {

            //エラーメッセージを消す
            this.errors = [];

            //データ送信
            axios
                .post('/program/' + this.program_id, {
                    voice_id: this.voice_id,
                })
                .then(() => {

                    //親要素の配列にレビューを追加
                    this.$emit("change_voice_id", this.voice_id);

                    //ウインドウを消して終了
                    this.display_flag = false;
                })
                .catch((error) => {
                    this.errors.push(error.response.data);
                });
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
    .program-description {
        margin-bottom: 12px;
        span {
            font-weight: bold;
            padding: 0 2px;
        }
    }
    .program-form {
        .program-form-item {
            margin-bottom: 8px;
        }
        label {
            display: block;
        }
        select {
            margin: 4px 6px 0;
            height: 30px;
            background-color: #ded9e5;
            outline: none;
            border: unset;
            border-radius: 4px;
            padding: 4px 10px;
            width: calc(100% - 12px);
            @media screen and (min-width: $bp) {
                margin: 4px 16px 0;
                width: calc(100% - 32px);
            }
        }
        .error-message {
            color: $font-color-error;
            text-align: center;
            font-weight: bold;
        }
    }
</style>