<template>

    <!-- サイト本体部分 -->
    <div class="inner">

        <h2 class="h2-title">このサイトについて</h2>

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

            <p>　プレイヤーが実況や音読をしたり、雑談を交えながらゲームをプレイするというスタイルの動画は、2007年ころからニコニコ動画に投稿され始め、現在では日本だけでなく世界中で楽しまれています。</p>
            <p>　このサイトは、ゲームファンや実況動画ファン、そして実況者自身が、より多くのゲームを楽しむために利用することを目的としています。</p>
            <p>　また、ゲームメーカーやゲーム業界にとっても、このような実況プレイ動画がより多くの人々に紹介され、ゲームの普及やファン層の拡大につながることを期待しています。</p>

        </section>

    </div>

    <div>
        当サイトは、YouTube Data API・ニコニコ動画 スナップショット検索API v2 を利用して動画情報を収集しています。
        できるだけ最新に近い情報を反映するように更新していますが、非公開にしたい動画やチャンネルなどがありましたらtwitterのDMでご連絡ください。
        また、当サイトはリンクフリーです。ご自由にリンクを張っていただいて大丈夫です。
    </div>

</template>


<script>
import {Link} from "@inertiajs/inertia-vue3";
import SvgIcon from "@/js/Components/SvgIcon.vue";
export default {

    //読み込んだコンポーネント
    components: {
        SvgIcon,
        Link,
    },
}
</script>


<style lang="scss" scoped>
@import "@/sass/variables";
    p {
        margin: 6px 0;
    }
    .h2-title {
        font-size: $font-xl;
        margin: 20px 0 0;
    }
    .section-1, .section-2 {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        margin-top: 40px;
        line-height: 1.4em;
    }
    .section-1 {
        .flex-left, .flex-right {
            display: block;
            width: 100%;
            padding: 4px 10px;
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
            height: 18px;
            text-align: right;
            svg {
                position: relative;
                top: 4px;
                width: 18px;
            }
        }
    }
    .section-2 {
    }
</style>