<template>
    <footer class="footer">

        <!-- サイトの開設年とコピーライト -->
        <div class="footer-copyright">
            2021 - {{ year }}<br>
            © {{ constants.site_title }}製作委員会
        </div>

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


<script>
export default {

    //返り値が固定の関数
    computed: {

        //laravel側から定数を取得する
        constants() {
            return this.$page.props.const;
        },

        //現在の年
        year() {
            var now = new Date();
            return now.getFullYear();
        },
    },
}
</script>


<style lang="scss" scoped>
@import "../../sass/variables";

    .footer {
        padding: 12px 0;
        background-color: $black;
        text-align: center;
        font-size: $font-s;
        color: #fff;
    }

    .footer-copyright {
        line-height: 2.0rem;
    }

    .footer-twitter {
        display: block;
        margin: 8px auto 0;
        width: 32px;
    }

</style>