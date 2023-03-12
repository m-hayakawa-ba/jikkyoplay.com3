<template>

    <!-- 再生回数表示 -->
    <CreaterViewCount
        v-if="creater.view_count"
        :rank="rank"
        :view_count="creater.view_count"
    />

    <!-- 番組情報 -->
    <InformationWrap style="justify-content: space-between;">

        <!-- 投稿者の顔アイコン -->
        <div class="creater-image">
            <img
                v-if="did_load_thumbnail"
                :src="creater.user_icon_url"
                :alt="creater.name"
                @error="loadingErrorNewsThumbnail"
            />
            <img
                v-else
                src="/image/noimage.png"
                alt="実況者画像なし"
            >
        </div>

        <!-- 投稿者の情報 -->
        <div class="creater-detail">

            <!-- 実況者の名前 -->
            <div class="creater-name">
                {{ creater.name }}
            </div>
            
            <!-- その他の動画 -->
            <div>
                <SearchLink 
                    name="この実況者さんの他の動画"
                    :query="'creater_id=' + creater.id"
                />
            </div>
            
            <!-- もとのページへ -->
            <div style="padding: 2px 0 1px;">
                <a :href="getChannelUrl()" class="site-link" target="_blank">
                    <img :src="getSiteIconUrl()">
                    <span>チャンネルページへ行く</span>
                </a>
            </div>
        </div>

    </InformationWrap>

</template>


<script lang="ts">
import { defineComponent } from "vue";

import { Creater } from '../../Interfaces/Creater';
import { getConstant } from '../../Interfaces/Constant';

import InformationWrap from "@/js/Components/Information/InformationWrap.vue";
import SearchLink from "@/js/Components/SearchLink.vue";
import CreaterViewCount from "@/js/Components/Creater/CreaterViewCount.vue";

export default defineComponent({

    //呼び出し元から渡された引数
    props: [
        "rank",     //ランキングがある場合、何位か（ランキングじゃない場合はnull）
        "creater",  //投稿者情報
    ],

    //コンポーネント内で使用する変数
    data() {
        return {
            did_load_thumbnail: true,
        };
    },

    //返り値が固定の関数
    computed: {

        //laravel側から定数を取得する
        constants(): any{
            return getConstant();
        },
    },

    //読み込んだコンポーネント
    components: {
        InformationWrap,
        SearchLink,
        CreaterViewCount,
    },

    //コンポーネント内で使用するメソッド
    methods: {

        //そのユーザーの外部チャンネルURLを返す
        getChannelUrl() {
            if (this.creater.site_id == this.constants.site.youtube) {
                return `https://www.youtube.com/channel/${this.creater.user_id}`;
            } else if (this.creater.site_id == this.constants.site.nicovideo) {
                return `https://www.nicovideo.jp/user/${this.creater.user_id}`;
            }
        },

        //そのユーザーの外部サイトのアイコンURLを返す
        getSiteIconUrl() {
            if (this.creater.site_id == this.constants.site.youtube) {
                return "/image/logo_youtube.webp";
            } else if (this.creater.site_id == this.constants.site.nicovideo) {
                return "/image/logo_nicovideo.webp";
            }
        },

        loadingErrorNewsThumbnail() {
            this.did_load_thumbnail = false;
        },
    },

    //初回読み込み時に実行
    mounted() {
    }

});
</script>


<style lang="scss" scoped>
@import "@/sass/variables";
    .creater-image {
        width:  104px;
        height: 104px;
        margin: 0 8px;
        img {
            object-fit: cover;
            width: 100%;
            border-radius: 2px;
            box-shadow: 1px 1px 4px rgb(32 6 6 / 12%);
        }
    }
    .creater-detail {
        width: calc(100% - 128px);
        margin-left: 4px;
        .creater-name {
            font-weight: bold;
            word-break: break-all;
            overflow: hidden;
            text-overflow: ellipsis;
            height: 44px;
        }
    }
    .site-link {
        position: relative;
        display: block;
        margin: 0 auto;
        padding: 2px 0 3px;
        width: 80%;
        min-width: 208px;
        border: solid 1px #8d8186;
        background-color: #ffffff;
        border-radius: 4px;
        text-align: center;
        font-weight: bold;
        img {
            display: inline;
            width: 28px;
            vertical-align: middle;
        }
        span {
            position: relative;
            top: 2px;
            margin-left: 4px;
            vertical-align: middle;
        }
    }

</style>