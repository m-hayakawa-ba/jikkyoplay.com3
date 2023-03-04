<template>

    <!-- サイト本体部分 -->
    <div class="inner">
        
        <!-- 視聴履歴 -->
        <H2Title
            title_jp="このサイトについて"
            title_en="ABOUT THIS SITE"
        />

        <section class="section-1">
            <div class="flex-left">
                <p>　このサイトは、YouTubeやニコニコ動画など複数の動画サイトに投稿されたゲームの実況プレイ動画をまとめたサイトです。</p>
                <p>　主にシリーズもののpart1動画を扱っており、再生数を元にした動画ランキングや人気実況者ランキングの他、最新のゲーム実況ニュースも掲載しています。</p>
                <p>　また、ゲームのタイトルやハード、メーカー、発売年などで動画を分類し、お好みの実況プレイ動画を効率よく検索できます。</p>
            </div>
            <Link href="/ranking" class="flex-right">
                <div class="image">
                    <img src="/image/banner/ranking_total.jpg" alt="ゲーム実況ランキングページへ">
                </div>
                <div class="caption">
                    ゲーム実況ランキングページへ
                    <SvgIcon icon="single_right"/>
                </div>
            </Link>
        </section>

        <section class="section-2">
            <div class="flex-left">
                <p>　プレイヤーが実況や音読をしたり、雑談を交えながらゲームをプレイするというスタイルの動画は、2007年ころからニコニコ動画に投稿され始め、現在では日本だけでなく世界中で楽しまれています。</p>
                <p>　このサイトは、ゲームファンや実況動画ファンが、より多くのゲームを楽しむために利用することを目的としています。</p>
                <p>　また、ゲームメーカーやゲーム業界にとっても、このような実況プレイ動画がより多くの人々に紹介され、ゲームの普及やファン層の拡大につながることを期待しています。</p>
            </div>
            <div class="flex-right">
                <ProgramWrap rank="" :program="program"/>
                <div class="caption">
                    シリーズ物の実況プレイ動画の中で、現在確認されている最古のゲーム実況動画
                </div>
            </div>
        </section>

        <section class="section-3">
            <p>当サイトは、YouTube Data API・ニコニコ動画 スナップショット検索API v2 を利用して動画情報を収集しています。</p>
            <p>できるだけ最新に近い情報を反映するように更新していますが、非公開にしたい動画やチャンネルなどがありましたらtwitterのDMでご連絡ください。</p>
            <p>また、当サイトはリンクフリーです。ご自由にリンクを張っていただいて大丈夫です。</p>
        </section>

    </div>

</template>


<script>
import {Link, usePage} from "@inertiajs/inertia-vue3";
import H2Title from "@/js/Components/H2Title.vue";
import SvgIcon from "@/js/Components/SvgIcon.vue";
import ProgramWrap from "@/js/Components/Program/ProgramWrap.vue";
export default {

    //読み込んだコンポーネント
    components: {
        H2Title,
        SvgIcon,
        Link,
        ProgramWrap,
    },

    //コンポーネント内で使用する変数
    data() {
        return {
            program: usePage().props.value.program,
        };
    },
}
</script>


<style lang="scss" scoped>
@import "@/sass/variables";
    p {
        margin: 10px 0;
        @media screen and (min-width: $bp) {
            margin: 6px 0;
        }
    }
    .h2-title {
        font-size: $font-xl;
        margin: 20px 0 0;
    }
    .section-1, .section-2, .section-3 {
        display: flex;
        flex-wrap: wrap;
        margin-top: 10px;
        align-items: center;
        line-height: 1.4em;
        @media screen and (min-width: $bp) {
            margin-top: 30px;
        }
        .flex-left, .flex-right {
            display: block;
            width: 100%;
            padding: 4px 0;
            @media screen and (min-width: $bp) {
                width: 50%;
                padding: 0 20px;
            }
        }
        .image {
            border-radius: 4px;
            overflow: hidden;
            box-shadow: 1px 1px 2px #00000040;
        }
        .caption {
            position: relative;
            font-size: 1.2rem;
            svg {
                position: relative;
                top: 4px;
                width: 18px;
            }
        }
    }
    .section-1 {
        .caption {
            height: 18px;
            text-align: right;
        }
    }
    .section-2 {
        .caption {
            line-height: 1.4;
            bottom: 2px;
            text-align: justify;
        }
        @media screen and (min-width: $bp) {
            flex-flow: row-reverse;
        }
    }
</style>