<template>
    <div class="program-thumbnail">

        <!-- 画像本体 -->
        <img
            :src="program.image_url"
            :alt="program.title"
            class="thumbnail-img"
        />

        <!-- 動画サイトのアイコン -->
        <img
            v-if="program.site_id == constants.site.youtube"
            src="/image/logo_youtube.webp"
            alt="YouTube"
            class="thumbnail-icon"
        >
        <img
            v-if="program.site_id == constants.site.nicovideo"
            src="/image/logo_nicovideo.webp"
            alt="ニコニコ動画"
            class="thumbnail-icon"
        >

        <!-- 動画の説明部分 -->
        <div class="program-caption">

            <!-- 投稿者アイコン -->
            <div class="caption-creater-icon">
                <img
                    v-if="did_load_creater_thumbnail"
                    :src="program.user_icon_url"
                    :alt="program.creater_name"
                    @error="loadingErrorCreaterThumbnail"
                />
                <img
                    v-else
                    src="/image/noimage_trans.png"
                    :alt="program.creater_name"
                />
            </div>

            <!-- 投稿者名と投稿日 -->
            <div class="caption-detail">
                {{ program.creater_name }}<br>
                {{ format(program.published_at) }} 投稿（{{ program.view_count.toLocaleString() }}回再生）
            </div>
        </div>
    </div>
</template>


<script lang="ts">

import { defineComponent } from "vue";
import moment from 'moment';

import { getConstant } from '../../Interfaces/Constant';

export default defineComponent({

    //呼び出し元から渡された引数
    props: [
        "program",
    ],

    //コンポーネント内で使用する変数
    data() {
        return {
            did_load_creater_thumbnail: true,
        };
    },

    //返り値が固定の関数
    computed: {

        //laravel側から定数を取得する
        constants(): any{
            return getConstant();
        },
    },

    //コンポーネント内で使用するメソッド
    methods: {
        format(date: string) {
            return moment(date).format('YYYY年M月D日')
        },
        loadingErrorCreaterThumbnail() {
            this.did_load_creater_thumbnail = false;
        },
    },

    //初回読み込み時に実行
    mounted() {
        // console.log(this.site_id);
    }
});
</script>


<style lang="scss" scoped>
@import "@/sass/variables";
    .program-thumbnail {
        position: relative;
        width: 100%;
        height: 0;
        padding-top: calc(100% * 9 / 16);
        overflow: hidden;
        border-radius: 4px;
        .thumbnail-img {
            position: absolute;
            top: 50%;
            left: 0;
            width: 100%;
            transform: translateY(-50%);
        }
        .thumbnail-icon {
            position: absolute;
            width: 15%;
            top: 3px;
            right: 5px;
            @media screen and (min-width: $bp) {
                width: 12%;
            }
        }
    }
    .program-caption {
        position: absolute;
        bottom: 0;
        display: flex;
        align-items: center;
        padding: 4px;
        width: 100%;
        color: #fff;
        background-color: #000000b0;
        .caption-creater-icon {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            overflow: hidden;
        }
        .caption-detail {
            margin-left: 8px;
            font-size: $font-s;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    }
</style>