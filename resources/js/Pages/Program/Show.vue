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

        <!-- 動画の各種情報 -->
        <div class="information-wrap">

            <div class="information-wrap-left">

                <!-- 実況者情報 -->
                <div class="section-wrap">
                    <h3>実況者情報</h3>
                    <CreaterWrap :creater="creater"/>
                </div>

                <!-- 動画情報 -->
                <div class="section-wrap">
                    <h3>動画情報</h3>
                    <ProgramSimpleWrap
                        :site_id="creater.site_id"
                        :site_name="creater.site_name"
                        :voice_id="program.voice_id"
                        :voice_type="program.voice_type"
                    />
                    <ModalUpdateProgram
                        :program_id="program.id"
                        :default_voice_id="program.voice_id"
                        @change_voice_id="changeVoiceId"
                    />
                </div>

                <!-- ゲーム情報 -->
                <div class="section-wrap">
                    <h3>ゲーム情報</h3>
                    <GameWrap  :game="game"/>
                    <ModalUpdateGame/>
                </div>
            </div>

            <div class="information-wrap-right">
                <!-- ゲームレビュー -->
                <div class="review-wrap">
                    <h3>動画レビュー</h3>
                    <ReviewSimpleWrap
                        v-for="review in reviews"
                        :key="review.id"
                        :review="review"
                    />
                    <ModalCreateReview
                        :program_id="program.id"
                        :creater_name="creater.name"
                        @push_review="pushReview"
                    />
                </div>
            </div>

        </div>

        <!-- 関連動画 -->
        <div class="relation-program-wrap">
            <h3>関連動画</h3>
            <div class="program-wrap">
                <div
                    v-for="program in relation_programs"
                    class="program-item"
                >
                    <ProgramWrap
                        :rank="null"
                        :program="program"
                    />   
                </div>
            </div>
        </div>

    </div>
</template>


<script>
import {usePage} from "@inertiajs/inertia-vue3";
import moment from 'moment';
import CreaterWrap        from '@/js/Components/Creater/CreaterWrap.vue';
import GameWrap           from '@/js/Components/Game/GameWrap.vue';
import ModalUpdateGame    from '@/js/Components/Game/ModalUpdateGame.vue';
import ProgramSimpleWrap  from '@/js/Components/Program/ProgramSimpleWrap.vue';
import ProgramWrap        from '@/js/Components/Program/ProgramWrap.vue';
import ModalUpdateProgram from '@/js/Components/Program/ModalUpdateProgram.vue';
import EmbedYoutube       from '@/js/Components/Program/EmbedYoutube.vue';
import EmbedNicovideo     from '@/js/Components/Program/EmbedNicovideo.vue';
import ReviewSimpleWrap   from '@/js/Components/Review/ReviewSimpleWrap.vue';
import ModalCreateReview  from '@/js/Components/Review/ModalCreateReview.vue';
import SearchLink         from "@/js/Components/SearchLink.vue";
import SvgIcon            from "@/js/Components/SvgIcon.vue";
export default {

    //読み込んだコンポーネント
    components: {
        CreaterWrap,
        GameWrap,
        ProgramSimpleWrap,
        ProgramWrap,
        ReviewSimpleWrap,
        EmbedYoutube,
        EmbedNicovideo,
        ModalCreateReview,
        ModalUpdateGame,
        ModalUpdateProgram,
        SearchLink,
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
            program:            usePage().props.value.program,
            creater:            usePage().props.value.creater,
            game:               usePage().props.value.game,
            reviews:            usePage().props.value.reviews,
            relation_programs:  usePage().props.value.relation_programs,
            list_voices:        usePage().props.value.list_voices,
        };
    },

    //コンポーネント内で使用するメソッド
    methods: {

        //日時の表示
        format(date) {
            return moment(date).format('YYYY年M月D日')
        },
        
        //画像がなかった場合の表示
        noImage(element){
            element.target.src = '/image/noimage_trans.png'
        },

        //音声情報を変更する
        changeVoiceId(voice_id) {
            this.program.voice_id = voice_id;
            this.program.voice_type = this.list_voices.find(el => el.id == voice_id).type;
        },

        //レビューを追加する
        pushReview(review) {
            this.reviews.push(review);
        },
    },

    //初回読み込み時に実行
    mounted() {
        console.log(this.creater);
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
        margin: 30px auto 30px;
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
        flex-wrap: wrap;
        justify-content: space-between;
    }
    .information-wrap-left {
        width: 100%;
        @media screen and (min-width: $bp) {
            padding: 0 10px;
            width: 45%;
        }
    }
    .information-wrap-right {
        width: 100%;
        @media screen and (min-width: $bp) {
            padding: 0 10px;
            width: 55%;
        }
    }
    h3 {
        font-size: $font-l;
        font-weight: bold;
        margin: 12px 0 4px;
        border-bottom: solid 1px #888;
    }
    .section-wrap {
        position: relative;
        width: 100%;
        margin-bottom: 20px;
    }
    .review-wrap {
        width: 100%;
        margin-bottom: 20px;
        @media screen and (min-width: $bp) {
            margin-bottom: 30px;
        }
    }
    .relation-program-wrap {
        margin-bottom: 20px;
        @media screen and (min-width: $bp) {
            margin-bottom: 30px;
        }
    }
    .program-wrap {
        margin-top: 4px;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }
    .program-item {
        position: relative;
        margin: 8px 0 0;
        width: 100%;
        @media screen and (min-width: $bp) {
            width: 49%;
        }
    }
</style>