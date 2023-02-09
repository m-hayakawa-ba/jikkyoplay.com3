<template>

    <div class="caption-wrap">

        <!-- 番組タイトル -->
        <div class="caption-title">
            {{ title }}
        </div>

        <!-- 投稿者情報 -->
        <div class="caption-creater">

            <!-- 投稿者アイコン -->
            <div class="caption-creater-icon">
                <img
                    :src="creater_icon_url"
                    :alt="creater_name"
                    @error="noImage"
                >
            </div>

            <!-- 投稿者名と投稿日 -->
            <div class="caption-creater-detail">
                {{ creater_name }}<br>
                {{ format(published_at) }} 投稿<br>
            </div>
        </div>
    </div>
</template>


<script>
import moment from 'moment';
export default {

    //呼び出し元から渡された引数
    props: [
        "title",
        "creater_name",
        "creater_icon_url",
        "published_at",
    ],

    //コンポーネント内で使用するメソッド
    methods: {
        format(date) {
            return moment(date).format('YYYY年M月D日')
        },
        
        noImage(element){
            element.target.src = '/image/noimage_trans.png'
        },
    },

}
</script>


<style lang="scss" scoped>
@import "@/sass/variables";

    .caption-wrap {
        width: 100%;
        padding: 2px 4px 0;
        @media screen and (min-width: $bp) {
            padding: 4px;
        }
    }
    .caption-title {
        font-weight: bold;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 3;
        overflow: hidden;
        line-height: 2.0rem;
        word-break: break-all;
    }
    .caption-creater {
        display: flex;
        align-items: center;
        @media screen and (min-width: $bp) {
            margin-top: 8px;
        }
    }
    .caption-creater-icon {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        overflow: hidden;
        span {
            width: 58px;
        }
    }
    .caption-creater-detail {
        margin-left: 8px;
        font-size: $font-s;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>