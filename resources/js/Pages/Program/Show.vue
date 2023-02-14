<template>

    <!-- サイト本体部分 -->
    <div class="inner">

        <!-- 埋め込み動画 -->
        <div class="program-background">

            <!-- youtube -->
            <EmbedYoutube
                v-if="creater.site_id == constants.site.youtube"
                :movie_id="program.movie_id"
            />
            <!-- ニコニコ動画 -->
            <EmbedNicovideo
                v-if="creater.site_id == constants.site.nicovideo"
                :movie_id="program.movie_id"
            />
        </div>

        <!-- 再生数と投稿日時 -->
        <div>
            <span>{{ format(program.published_at) }} 投稿</span>
            <span>（ {{program.view_count.toLocaleString()}}回 再生 ）</span>
        </div>

        <!-- 動画タイトル -->
        <h2 class="program-title">
            {{ program.title }}
        </h2>

        <!-- 元サイトへの外部リンク -->
        <a
            v-if="creater.site_id == constants.site.youtube"
            :href="'https://www.youtube.com/watch?v=' + program.movie_id"
            target="_blank"
            class="link-youtube"
        >
            <span>YouTube で見る</span>
            <SvgIcon icon="external_link" class="external-icon" />
        </a>
        <a
            v-if="creater.site_id == constants.site.nicovideo"
            :href="'https://www.nicovideo.jp/watch/' + program.movie_id"
            target="_blank"
            class="link-nicovideo"
        >
            <span>ニコニコ動画 で見る</span>
            <SvgIcon icon="external_link" class="external-icon" />
        </a>

        <!-- 動画情報と投稿者情報 -->
        <div class="information-wrap">
            <div class="game-data-wrap">
                <GameWrap 
                    :game="game"
                />
            </div>
            <div class="creater-wrap">
                <CreaterWrap
                    :creater="creater"
                />
            </div>
        </div>

    </div>
</template>


<script>
import {usePage} from "@inertiajs/inertia-vue3";
import moment from 'moment';
import CreaterWrap from '@/js/Components/Creater/CreaterWrap.vue';
import GameWrap from '@/js/Components/Game/GameWrap.vue';
import EmbedYoutube from '@/js/Components/Program/EmbedYoutube.vue';
import EmbedNicovideo from '@/js/Components/Program/EmbedNicovideo.vue';
import SvgIcon from "@/js/Components/SvgIcon.vue";
export default {

    //読み込んだコンポーネント
    components: {
        CreaterWrap,
        GameWrap,
        EmbedYoutube,
        EmbedNicovideo,
        SvgIcon,
    },

    //返り値が固定の関数
    computed: {

        //laravel側から定数を取得する
        constants() {
            return this.$page.props.const;
        },
    },

    //コンポーネント内で使用する変数
    data() {
        return {
            program:  usePage().props.value.program,
            creater:  usePage().props.value.creater,
            game:     usePage().props.value.game,
        };
    },

    //コンポーネント内で使用するメソッド
    methods: {
        format(date) {
            return moment(date).format('YYYY年M月D日')
        },
        
        noImage(element){
            element.target.src = '/image/noimage_trans.png'
        },
    },

    //初回読み込み時に実行
    mounted() {
    }

}
</script>


<style lang="scss" scoped>
@import "@/sass/variables";
    .program-background {
        margin: 20px 0 8px;
        background-color: #000;
        border-radius: 4px;
        overflow: hidden;
        @media screen and (min-width: $bp) {
            padding: 0 72px;
        }
    }
    .program-title {
        font-size: $font-l;
        @media screen and (min-width: $bp) {
            font-size: $font-xl;
        }
    }
    .link-youtube,
    .link-nicovideo {
        display: block;
        margin: 24px auto 0;
        width: 208px;
        text-align: center;
        font-size: 1.6rem;
        padding: 8px 0px;
        border-radius: 10px;
    }
    .link-youtube {
        color: #fff;
        background-color: #f00;
        border: solid 2px #f00;
    }
    .link-nicovideo {
        color: #fff;
        background-color: #424be4;
        border: solid 2px #424be4;
    }
    .external-icon {
        position: relative;
        bottom: 3px;
        display: inline;
        width: 24px;
        height: 24px;
        margin-left: 4px;
        vertical-align: top;
    }

    .information-wrap {
        display: flex;
        justify-content: space-between;
        margin: 40px 0 0 0;
    }
    .game-data-wrap {
        width: 48%;
    }
    .creater-wrap {
        width: 48%;
    }

</style>