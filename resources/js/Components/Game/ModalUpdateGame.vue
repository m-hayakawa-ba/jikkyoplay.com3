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
        <div class="game-description">
            動画のゲーム情報が間違っていた場合、修正することができます。
        </div>

        <!-- フォーム・ゲームの検索 -->
        <form
            class="game-form"
            @submit.prevent="submitGameSearchName"
        >
            <div class="game-form-item">
                <label for="game_search_name">ゲーム名</label>
                <input
                    type="text"
                    id="game_search_name"
                    required
                    v-model="game_search_name"
                />
            </div>

            <!-- エラーメッセージ -->
            <ul v-for="error in game_search_name_errors" class="error-message">
                <li>
                    {{ error }}
                </li>
            </ul>

            <!-- 送信ボタン -->
            <ButtonSubmit button_text="検索する" />
            
        </form>

        <!-- フォーム・ゲームの選択 -->
        <form
            v-if="games.length > 0"
            class="game-form"
            @submit.prevent="submitGameId"
        >
            <div class="game-form-item">
                <label>正しいゲームを選んでください</label>
                <div
                    v-for="game in games"
                    :key="game.id"
                >
                    <input
                        :id="'game_id-' + game.id"
                        type="radio"
                        v-model="game_id"
                        :value="game.id"
                    >
                    <label
                        :for="'game_id-' + game.id"
                        class="game-list"
                    >
                        <div class="game-list-hard">{{ game.hard_name }}</div>
                        <div class="game-list-name">{{ game.name }}</div>
                    </label>
                </div>

                <!-- エラーメッセージ -->
                <ul v-for="error in game_id_errors" class="error-message">
                    <li>
                        {{ error }}
                    </li>
                </ul>
            </div>

            <!-- 送信ボタン -->
            <ButtonSubmit button_text="このゲームで決定" />
            
        </form>
    </ModalWrap>
</template>


<script>
import ModalWrap from "@/js/Components/Modal/ModalWrap.vue";
import SvgIcon from "@/js/Components/SvgIcon.vue";
import ButtonSubmit from "@/js/Components/Modal/ButtonSubmit.vue";
export default {

    //呼び出し元から渡された引数
    props: [
        "program_id",
    ],

    //呼び出し元の書き換え
    emits: [
        'change_game_id'
    ],

    //コンポーネント内で使用する変数
    data() {
        return {
            display_flag: false,         //モーダルの表示フラグ
            game_search_name: "",        //検索フォームで使用する検索ワード
            game_search_name_errors: [], //検索フォームで使用するエラーメッセージ
            games: [],                   //選択フォームで使用するゲームの配列
            game_id: "",                 //選択フォームで使用するゲームid
            game_id_errors: [],          //選択フォームで使用するエラーメッセージ
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
        submitGameSearchName() {

            //エラーメッセージを消す
            this.game_search_name_errors = [];
            this.game_id_errors = [];

            //ゲームリストをリセット
            this.games = [];
            this.game_id = "";

            //データ送信
            axios
                .post('/game/search', {
                    game_search_name: this.game_search_name,
                })
                .then((response) => {
                    
                    //ゲームリストの配列に設定
                    this.games = response.data;
                })
                .catch((error) => {
                    this.game_search_name_errors.push(error.response.data);
                });
        },
        
        //フォームの送信
        submitGameId() {

            //エラーメッセージを消す
            this.game_search_name_errors = [];
            this.game_id_errors = [];

            //何も選択されていない場合
            if (this.game_id == "") {
                this.game_id_errors.push("リストからゲームを選んでください");
                return;
            }

            //データ送信
            axios
                .post('/game/update/' + this.program_id, {
                    game_id: this.game_id,
                })
                .then(() => {

                    //親要素の配列にレビューを追加
                    let game = this.games.find(el => el.id == this.game_id);
                    this.$emit(
                        "change_game_id",
                        game.id,
                        game.name,
                        game.hard_name,
                        game.maker_name,
                        game.releace_year,
                    );

                    //ウインドウを消して終了
                    this.display_flag = false;
                })
                .catch((error) => {
                    this.game_id_errors.push(error.response.data);
                });
        },

        mounted() {
            // console.log(this.program_id);
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
    .game-description {
        margin-bottom: 12px;
        span {
            font-weight: bold;
            padding: 0 2px;
        }
    }
    .game-form {
        margin-top: 20px;
        .game-form-item {
            margin-bottom: 8px;
        }
        label {
            display: block;
        }
        input, select {
            margin: 4px 6px 0;
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
        input {
            height: 30px;
            &[type="radio"] {
                display: none;
                &:checked + label {
                    background-color: #5e67bd;
                    border-color: #5e67bd;
                    color: #fff;
                    transition:
                        background-color 0.3s,
                        border-color 0.3s,
                        color 0.3s;
                }
            }
        }
        .game-list {
            margin: 4px auto;
            padding: 2px 4px;
            border: solid 1px #444;
            border-radius: 4px;
            width: calc(100% - 8px);
            max-width: 480px;
        }
        .game-list-hard {
            font-size: $font-s;
        }
        .game-list-name {
            font-size: $font-m;
        }
        .error-message {
            color: $font-color-error;
            text-align: center;
            font-weight: bold;
        }
    }
</style>