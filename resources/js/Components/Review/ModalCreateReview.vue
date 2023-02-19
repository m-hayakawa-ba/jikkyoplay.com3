<template>

    <!-- レビューを書くボタン -->
    <div
        @click="display_flag=true"
        class="review-modal-button"
    >
        動画レビューを書く
        <SvgIcon icon="edit" class="edit-icon" />
    </div>

    <!-- レビューモーダル -->
    <transition>
        <div
            v-if="display_flag"
            class="black-layer"
            v-on:click.self="display_flag=false"
        >
            <!-- モーダル全体 -->
            <div class="modal-wrap">

                <!-- 閉じるボタン -->
                <div class="close-button" @click="display_flag=false">
                    <SvgIcon icon="cross" />
                </div>

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
                    <button type="submit">レビューを投稿する</button>
                </form>
            </div>
        </div>
    </transition>

</template>


<script>
import SvgIcon from "@/js/Components/SvgIcon.vue";
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
        SvgIcon,
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
    .review-modal-button {
        width: 172px;
        margin: 0 0 0 auto;
        padding-bottom: 2px;
        border: solid 1px #8b9699;
        border-radius: 4px;
        text-align: center;
        cursor: pointer;
        transition: opacity 0.3s;
        &:hover {
            opacity: 0.8;
        }
    }
    .edit-icon {
        position: relative;
        top: 4px;
        width: 20px;
        height: 20px;
    }
    .close-button {
        position: absolute;
        top: -36px;
        right: 0px;
        width: 30px;
        height: 30px;
        color: #fff;
        cursor: pointer;
        transition: opacity 0.3s;
        &:hover {
            opacity: 0.8;
        }
    }
    .black-layer {
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
        button {
            display: block;
            margin: 20px auto 0;
            padding: 8px 16px;
            background-color: unset;
            border: solid 2px #6f528f;
            color: #462966;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            transition:
                background-color 0.3s,
                color 0.3s;
            &:hover{
                background-color: #6f528f;
                color: #fff;
            }
        }
    }
</style>