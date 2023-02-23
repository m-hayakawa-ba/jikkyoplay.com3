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
                        placeholder="ゲーム名など"
                        v-model="word"
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
                        <select name="site_id" id="site_id" class="search-select" v-model="site_id">
                            <option value=""></option>
                            <option
                                v-for="site in search_sites"
                                :key="site.id"
                                :value="site.id"
                            >
                                {{ site.name }}
                            </option>
                        </select>
                    </div>

                    <!-- 声 -->
                    <div class="advanced-search-item">
                        <label for="voice_id" class="search-label">声</label>
                        <select name="voice_id" id="voice_id" class="search-select" v-model="voice_id">
                            <option value=""></option>
                            <option
                                v-for="voice in search_voices"
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
                        <select name="hard_id" id="hard_id" class="search-select" v-model="hard_id">
                            <option value=""></option>
                            <option
                                v-for="hard in search_hards"
                                :key="hard.id"
                                :value="hard.id"
                            >
                                {{ hard.name }}
                            </option>
                        </select>
                    </div>

                    <!-- 発売年 -->
                    <div class="advanced-search-item">
                        <label for="year" class="search-label">発売年</label>
                        <select name="year" id="year" class="search-select" v-model="year">
                            <option value=""></option>
                            <option
                                v-for="releace_year in releace_years"
                                :key="releace_year"
                                :value="releace_year"
                            >
                                {{ releace_year }}年
                            </option>
                        </select>
                    </div>

                    <!-- 実況者名 -->
                    <div class="advanced-search-item">
                        <label for="creater_name" class="search-label">実況者名</label>
                        <input
                            class="search-input"
                            type="text"
                            id="creater_name"
                            v-model="creater_name"
                        />
                    </div>

                    <!-- メーカー -->
                    <div class="advanced-search-item">
                        <label for="maker_name" class="search-label">メーカー</label>
                        <input
                            class="search-input"
                            type="text"
                            id="maker_name"
                            v-model="maker_name"
                        />
                    </div>

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

    //コンポーネント内で使用する変数
    data() {
        return {
            word: "",
            site_id: "",
            voice_id: "",
            hard_id: "",
            year: "",
            maker_name: "",
            creater_name: "",
            search_sites: usePage().props.value.search_sites,
            search_voices: usePage().props.value.search_voices,
            search_hards: usePage().props.value.search_hards,
            releace_years: [],
        };
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
        padding: 40px 0;
        width: 100%;
        height: calc(100vh - 100%);
        opacity: 0.95;
        background-color: #292a2a;
        color: #fff;
        text-align: center;
        overflow: scroll;
        @media screen and (min-width: $bp) {
            padding: 80px 0 0;
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
        background-color: #292a2a;
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
        border-radius: 50%;
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
        margin-bottom: 30px;
        .search-input,
        .search-select {
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
            width: 100%;
        }
        @media screen and (min-width: $bp) {
            margin-top: 100px;
            width: 640px;
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