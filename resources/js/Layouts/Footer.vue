<template>
    <footer class="footer">

        <!-- サイトの開設年とコピーライト -->
        <div class="footer-copyright">
            2021 - {{ year }}<br>
            © {{ constants.site_title }}製作委員会
        </div>

        <!-- このサイトについて -->
        <Link
            class="footer-about"
            href="/about">
            このサイトについて
        </Link>
    
        <!-- 公式twitterへのリンク -->
        <a
            class="footer-twitter"
            :href="constants.url.official_twitter"
            target="_blank"
        >
            <img src="/icon/twitter.svg" alt="twitter公式アカウント">
        </a>
    </footer>
</template>


<script lang="ts">
import { Link } from "@inertiajs/inertia-vue3";
import { getConstant } from '../Interfaces/Constant';

export default {

    //読み込んだコンポーネント
    components: {
        Link,
    },

    //返り値が固定の関数
    computed: {

        //laravel側から定数を取得する
        constants(): any{
            return getConstant();
        },

        //現在の年
        year() {
            var now = new Date();
            return now.getFullYear();
        },
    },
};
</script>


<style lang="scss" scoped>
@import "../../sass/variables";

    .footer {
        padding: 20px 0;
        background-color: $black;
        text-align: center;
        font-size: $font-m;
    }

    .footer-copyright {
        line-height: 2.0rem;
        color: #fff;
    }

    .footer-about {
        display: block;
        margin: 12px auto 0;
        color: #fff;
    }

    .footer-twitter {
        display: block;
        margin: 12px auto 0;
        width: 32px;
        color: #fff;
    }

</style>