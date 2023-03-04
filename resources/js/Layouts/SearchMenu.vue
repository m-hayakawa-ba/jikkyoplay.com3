<template>

    <!-- 検索ウインドウ -->
    <transition name="search-window">
        <div
            v-if="display_flag"
            class="search-window"
        >
            
            <!-- フォーム -->
            <form class="search-form" @submit.prevent="submit">

                <!-- 通常検索部分 -->
                <div class="main-search-wrap">
                    <input
                        class="search-input"
                        type="text"
                        placeholder="ゲーム名・実況者名・動画タイトルなど"
                        v-model="form.word"
                    />
                    <button type="submit" class="search-button">
                        検索する
                        <SvgIcon class="search-icon" icon="search" />
                    </button>
                </div>

                <!-- 詳細検索部分 -->
                <div class="advanced-search-wrap">

                    <!-- 動画サイト -->
                    <div class="advanced-search-item">
                        <label for="site_id" class="search-label">動画サイト</label>
                        <select name="site_id" id="site_id" class="search-select" v-model="form.site_id">
                            <option value=""></option>
                            <option
                                v-for="site in list_sites"
                                :key="site.id"
                                :value="site.id"
                            >
                                {{ site.name }}
                            </option>
                        </select>
                    </div>

                    <!-- 声 -->
                    <div class="advanced-search-item">
                        <label for="voice_id" class="search-label">音声</label>
                        <select name="voice_id" id="voice_id" class="search-select" v-model="form.voice_id">
                            <option value=""></option>
                            <option
                                v-for="voice in list_voices"
                                :key="voice.id"
                                :value="voice.id"
                            >
                                {{ voice.type }}
                            </option>
                        </select>
                    </div>

                    <!-- ハード -->
                    <div class="advanced-search-item">
                        <label for="hard_id" class="search-label">ハード</label>
                        <select name="hard_id" id="hard_id" class="search-select" v-model="form.hard_id">
                            <option value=""></option>
                            <option
                                v-for="hard in list_hards"
                                :key="hard.id"
                                :value="hard.id"
                            >
                                {{ hard.name }}
                            </option>
                        </select>
                    </div>

                    <!-- 発売年 -->
                    <!-- <div class="advanced-search-item">
                        <label for="year" class="search-label">発売年</label>
                        <select name="year" id="year" class="search-select" v-model="form.year">
                            <option value=""></option>
                            <option
                                v-for="releace_year in releace_years"
                                :key="releace_year"
                                :value="releace_year"
                            >
                                {{ releace_year }}年
                            </option>
                        </select>
                    </div> -->

                    <!-- 実況者名 -->
                    <!-- <div class="advanced-search-item">
                        <label for="creater_name" class="search-label">実況者名</label>
                        <input
                            class="search-input"
                            type="text"
                            id="creater_name"
                            v-model="form.creater_name"
                        />
                    </div> -->

                    <!-- メーカー -->
                    <div class="advanced-search-item">
                        <label for="maker_name" class="search-label">メーカー</label>
                        <input
                            class="search-input"
                            type="text"
                            id="maker_name"
                            v-model="form.maker_name"
                        />
                    </div>

                    <!-- ポイント -->
                    <input
                        type="hidden"
                        v-model="form.point"
                    >

                    <button type="submit" class="search-button">
                        詳細検索する
                        <SvgIcon class="search-icon" icon="search" />
                    </button>
                </div>
            </form>
        </div>
    </transition>

</template>


<script>
import { usePage } from "@inertiajs/inertia-vue3";
import SvgIcon from "@/js/Components/SvgIcon.vue";
export default {

    //呼び出し元から渡された引数
    props: [
        "display_flag", //表示フラグ
    ],

    //読み込んだコンポーネント
    components: {
        SvgIcon,
    },

    //呼び出し元の書き換え
    emits: [
        'set_search_display_flag'
    ],

    //コンポーネント内で使用する変数
    data() {
        return {
            form: this.$inertia.form({
                word: "",
                site_id: "",
                voice_id: "",
                hard_id: "",
                year: "",
                maker_name: "",
                creater_name: "",
                point: 4,
            }),
            list_sites: usePage().props.value.list_sites,
            list_voices: usePage().props.value.list_voices,
            list_hards: usePage().props.value.list_hards,
            releace_years: [],
        };
    },
    
    //コンポーネント内で使う関数
    methods: {

        //親コンポーネントの表示フラグを変更する
        setDisplay(flag) {
            this.$emit('set_search_display_flag', flag);
        },

        //モーダルの表示非表示の切り替え
        submit() {
            this.form.get('/program', {
                onSuccess: () => this.setDisplay(false),
            });
        },
    },

    //発売年の配列を作成する
    mounted() {
        let d = new Date();
        const this_year = d.getFullYear();
        for (let i = 1983; i < this_year; i++) {
            this.releace_years.push(i);
        }
    },
}
</script>


<style lang="scss" scoped>
@import "@/sass/variables";
    .search-window {
        position: absolute;
        top: 0;
        padding: 96px 0 80px;
        width: 100%;
        height: 100vh;
        opacity: 0.95;
        background-color: #292a2a;
        color: #fff;
        text-align: center;
        overflow: scroll;
        @media screen and (min-width: $bp) {
            padding: 120px 0 0;
            overflow: unset;
        }
    }

    //ウインドウ表示アニメーション
    .search-window-enter-from, .search-window-leave-to {
        opacity: 0;
    }
    .search-window-enter-active, .search-window-leave-active {
        transition: opacity 0.2s;
    }
    .search-window-enter-to, .search-window-leave {
        opacity: 0.95;
    }
    .search-label {
        display: block;
        padding-left: 20px;
        text-align: left;
    }
    .search-input,
    .search-select {
        display: block;
        border: solid 2px #ffffff;
        margin: 0 auto 10px;
        padding: 6px 12px;
        border-radius: 20px;
        width: 320px;
        background-color: #191a1c;
        &:focus {
            box-shadow: 0 0 4px #0ff;
            outline: none;
        }
        @media screen and (min-width: $bp) {
            margin-bottom: 40px;
            padding: 8px 12px;
        }
    }
    .search-button {
        display: block;
        margin: 0 auto;
        background-color: unset;
        border: none;
        font-size: $font-l;
        transition: opacity 0.3s;
        &:hover {
            opacity: 0.8;
        }
    }
    .search-icon {
        position: relative;
        top: 6px;
        margin-left: 2px;
        height: 24px;
        width: 24px;
    }
    .main-search-wrap {
        margin-bottom: 40px;
        .search-input,
        .search-select {
            height: 41px;
            max-width: 80%;
        }
    }
    .advanced-search-wrap {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        margin: 0 auto;
        width: 100%;
        max-width: 90%;
        .search-input,
        .search-select {
            height: 38px;
            width: 100%;
        }
        @media screen and (min-width: $bp) {
            margin-top: 100px;
            width: 640px;
            height: 40px;
            max-width: 100%;
        }
    }
    .advanced-search-item {
        width: 100%;
        padding: 0 30px;
        @media screen and (min-width: $bp) {
            width: 50%;
        }
    }
</style>