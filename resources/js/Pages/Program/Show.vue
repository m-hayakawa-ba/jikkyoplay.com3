<template>

    <!-- タイトル -->
    <Head>
        <title>{{ program.title }}｜ゲーム実況動画まとめサイト GameJDM</title>
        <meta name="description" :content="creater.name + 'さんのゲーム実況プレイ動画「' + program.title + '」'" />
        <link rel="canonical" :href="'https://jikkyoplay.com/program/' + program.id">
    </Head>

    <!-- サイト本体部分 -->
    <div class="inner">

        <!-- 埋め込み動画 -->
        <EmbedMovie
            :site_id="creater.site_id"
            :movie_id="program.movie_id"
        />

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
        <MovieSiteLink
            :site_id="creater.site_id"
            :movie_id="program.movie_id"
        />

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
                        :creater_id="creater.id"
                        :default_voice_id="program.voice_id"
                        @change_voice_id="changeVoiceId"
                    />
                </div>

                <!-- ゲーム情報 -->
                <div class="section-wrap">
                    <h3>ゲーム情報</h3>
                    <GameWrap  :game="game"/>
                    <ModalUpdateGame
                        :program_id="program.id"
                        @change_game_id="changeGameId"
                    />
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
                    <div
                        v-if="reviews.length == 0"
                        class="review-announce"    
                    >
                        この動画へのレビューはまだありません。<br />
                        レビューを書いて <span>{{ creater.name }}</span> さんを応援しよう！<br />
                        自分の動画の宣伝もOK！
                    </div>
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
import { Head, usePage } from "@inertiajs/inertia-vue3";
import moment from 'moment';
import CreaterWrap        from '@/js/Components/Creater/CreaterWrap.vue';
import GameWrap           from '@/js/Components/Game/GameWrap.vue';
import ModalUpdateGame    from '@/js/Components/Game/ModalUpdateGame.vue';
import ProgramSimpleWrap  from '@/js/Components/Program/ProgramSimpleWrap.vue';
import ProgramWrap        from '@/js/Components/Program/ProgramWrap.vue';
import ModalUpdateProgram from '@/js/Components/Program/ModalUpdateProgram.vue';
import ReviewSimpleWrap   from '@/js/Components/Review/ReviewSimpleWrap.vue';
import ModalCreateReview  from '@/js/Components/Review/ModalCreateReview.vue';
import EmbedMovie         from "@/js/Pages/Program/Show__EmbedMovie.vue";
import MovieSiteLink      from "@/js/Pages/Program/Show__MovieSiteLink.vue";
export default {

    //読み込んだコンポーネント
    components: {
        Head,
        CreaterWrap,
        GameWrap,
        ProgramSimpleWrap,
        ProgramWrap,
        ReviewSimpleWrap,
        ModalCreateReview,
        ModalUpdateGame,
        ModalUpdateProgram,
        EmbedMovie,
        MovieSiteLink,
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

        //ゲーム情報を変更する
        changeGameId(game_id, game_name, hard_name, maker_name, releace_year) {
            this.game.id            = game_id;
            this.game.name          = game_name;
            this.game.hard_name     = hard_name;
            this.game.maker_name    = maker_name;
            this.game.releace_year  = releace_year;
        },

        //レビューを追加する
        pushReview(review) {
            this.reviews.push(review);
        },
    },

    //初回読み込み時に実行
    mounted() {
        // console.log(this.creater);
    }

}
</script>


<style lang="scss" scoped>
@import "@/sass/variables";
    .program-title {
        font-size: $font-l;
        @media screen and (min-width: $bp) {
            font-size: $font-xl;
        }
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
    .review-announce {
        margin-bottom: 20px;
        span {
            font-weight: bold;
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
        margin-bottom: 12px;
        width: 100%;
        @media screen and (min-width: $bp) {
            margin: 0 0.166% 24px;
            width: 33%;
        }
    }
</style>