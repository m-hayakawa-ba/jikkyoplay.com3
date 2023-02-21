<template>

    <!-- モーダル表示ボタン -->
    <ButtonOpen
        button_text="動画レビューを書く"
        @click="display_flag=true"
    />

    <!-- レビューモーダル -->
    <ModalWrap
        :display_flag="display_flag"
        @set_display="setDisplay"
    >

        <!-- モーダルの内容 -->
        <div class="review-description">
            動画のレビューを書いて<span>{{ creater_name }}</span>さんを応援しよう！
        </div>

        <!-- フォーム -->
        <form class="review-form" @submit.prevent="submit">
            <div class="review-form-item">
                <label for="reviewer">レビューを書く人の名前</label>
                <input
                    type="text"
                    id="reviewer"
                    required
                    v-model="reviewer"
                />
            </div>
            <div class="review-form-item">
                <label for="detail">レビュー本文</label>
                <textarea
                    id="detail"
                    required
                    v-model="detail"
                    :style="styles"
                    ref="detail"
                ></textarea>
                <div class="review-length">文字数：{{ detail.length }} / 500</div>
            </div>

            <!-- エラーメッセージ -->
            <ul v-for="error in errors" class="error-message">
                <li>
                    {{ error }}
                </li>
            </ul>

            <!-- 送信ボタン -->
            <ButtonSubmit button_text="レビューを投稿する" />
            
        </form>
    </ModalWrap>
</template>


<script>
import ModalWrap from "@/js/Components/Modal/ModalWrap.vue";
import ButtonOpen from "@/js/Components/Modal/ButtonOpen.vue";
import ButtonSubmit from "@/js/Components/Modal/ButtonSubmit.vue";
export default {

    //呼び出し元から渡された引数
    props: [
        "program_id",
        "creater_name",
    ],

    //コンポーネント内で使用する変数
    data() {
        return {
            display_flag: false,
            reviewer: "",
            detail: "",
            errors: [],
            height: "80px",
        };
    },

    //呼び出し元の書き換え
    emits: [
        'push_review'
    ],

    //読み込んだコンポーネント
    components: {
        ModalWrap,
        ButtonOpen,
        ButtonSubmit,
    },

    // 入力の監視
    watch:{
        detail () {

            //テキストエリアを拡大させる
            this.textareaResize();
        },
    },

    //キャッシュする関数
    computed: {
        styles() {
            return {
                "height": this.height,
            }
        }
    },

    //コンポーネント内で使う関数
    methods: {

        //モーダルの表示非表示の切り替え
        setDisplay(flag) {
            this.display_flag = flag;
        },

        //テキストエリアのリサイズ
        textareaResize() {
            this.height = "auto";
            this.$nextTick(()=>{
                if (this.$refs.detail?.scrollHeight <= 80) {
                    this.height = "80px";
                } else if (this.$refs.detail?.scrollHeight >= 240) {
                    this.height = "240px";
                } else {
                    this.height = this.$refs.detail?.scrollHeight + 'px';
                }
            });
        },

        //フォームの送信
        submit() {

            //エラーメッセージを消す
            this.errors = [];

            //バリデーションチェック
            if (this.detail.length > 500) {
                this.errors = ["入力文字数が多すぎます"];
                return;
            }

            //データ送信
            axios.post('/review', {
                program_id: this.program_id,
                reviewer:   this.reviewer,
                detail:     this.detail,
            })
                .then((response) => {

                    //親要素の配列にレビューを追加
                    this.$emit("push_review", response.data);

                    //表示をリセット
                    this.reviewer     = "";
                    this.detail       = "";

                    //ウインドウを消して終了
                    this.display_flag = false;
                })
                .catch((error) => {
                    this.errors.push(error.response.data.message);
                });
        }
    },
}
</script>


<style lang="scss" scoped>
@import "@/sass/variables";
    .review-description {
        margin-bottom: 12px;
        span {
            font-weight: bold;
            padding: 0 2px;
        }
    }
    .review-form {
        .review-form-item {
            margin-bottom: 8px;
        }
        label {
            display: block;
        }
        input, textarea {
            margin: 4px 0 0 16px;
            background-color: #ded9e5;
            outline: none;
            border: unset;
            border-radius: 4px;
            padding: 4px 10px;
            width: calc(100% - 16px);
        }
        textarea {
            resize: none;
        }
        .review-length {
            text-align: right;
            font-size: $font-s;
        }
        .error-message {
            color: $font-color-error;
            text-align: center;
            font-weight: bold;
        }
    }
</style>