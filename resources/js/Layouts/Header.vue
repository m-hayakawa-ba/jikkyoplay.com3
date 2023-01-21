<template>
    <header>
        <div class="header-wrap">

            <!-- サイトロゴ -->
            <a class="header-logo">
                <img src="/image/logo.png" :alt="constants.site_title">
            </a>

            <!-- 検索マーク -->
            <div class="header-search">
                <img src="/icon/search.svg" alt="検索アイコン">
            </div>

            <!-- ドロワーメニュー -->
            <div class="header-hamburger">
                <img src="/icon/hamburger.svg" alt="ハンバーガーアイコン">
            </div>

        </div>
    </header>
</template>


<script>
export default {

    //返り値が固定の関数
    computed: {

        //laravel側から定数を取得する
        constants() {
            return this.$page.props.const;
        },
    }
}
</script>


<style lang="scss" scoped>

    header {
        padding: 8px 8px;
        border-bottom: solid 1px #ddd;
        box-shadow: 0px 0px 4px #00000020;
    }
    .header-wrap {
        display: grid;
        align-items: center;
        grid-template-columns: auto 42px 42px;
        max-width: 960px;
        margin: 0 auto;
    }

    .header-logo {
        width: 168px;
    }

    .header-search {
        width: 26px;
        margin: 0 0 0 auto;
    }
    
    .header-hamburger {
        width: 24px;
        margin: 0 0 0 auto;
    }

</style>