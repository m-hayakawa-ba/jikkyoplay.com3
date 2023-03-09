<template>

    <!-- 再生回数表示 -->
    <CreaterViewCount
        v-if="creater.view_count"
        :rank="rank"
        :view_count="creater.view_count"
    />

    <!-- 番組情報 -->
    <InformationWrap>

        <!-- 投稿者の顔アイコン -->
        <div class="creater-image">
            <img
                :src="creater.user_icon_url"
                :alt="creater.name"
                @error="noImage"
            >
        </div>

        <!-- 投稿者の情報 -->
        <table>

            <!-- 実況者の名前 -->
            <tr><th>
                {{ creater.name }}
            </th></tr>
            
            <!-- その他の動画 -->
            <tr><td>
                <SearchLink 
                    name="この実況者さんの他の動画"
                    :query="'creater_id=' + creater.id"
                />
            </td></tr>
            
            <!-- もとのページへ -->
            <tr><td style="padding: 2px 0 1px;">
                <a :href="getChannelUrl()" class="site-link" target="_blank">
                    <img :src="getSiteIconUrl()">
                    <span>チャンネルページへ行く</span>
                </a>
            </td></tr>
        </table>

    </InformationWrap>

</template>


<script>
import InformationWrap from "@/js/Components/Information/InformationWrap.vue";
import SearchLink from "@/js/Components/SearchLink.vue";
import CreaterViewCount from "@/js/Components/Creater/CreaterViewCount.vue";
export default {

    //呼び出し元から渡された引数
    props: [
        "rank",     //ランキングがある場合、何位か（ランキングじゃない場合はnull）
        "creater",  //投稿者情報
    ],

    //返り値が固定の関数
    computed: {

        //laravel側から定数を取得する
        constants() {
            return this.$page.props.const;
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
        
        noImage(element){
            element.target.src = '/image/noimage.png'
        }
    },

    //初回読み込み時に実行
    mounted() {
    }

}
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
    .caption-wrap {
        margin-left: 2px;
        padding: 2px 16px;
        width: calc(100% - 98px);
    }
    table {
        width: calc(100% - 128px);
    }
    th {
        font-weight: bold;
        word-break: break-all;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    td {
        padding: 2px 0 2px 8px;
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