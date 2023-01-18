<template>
    <footer>
        <a
            :href="constants.url.official_twitter"
        >
            <img src="/icon/twitter.svg" alt="twitter公式アカウント">
        </a>
    </footer>
</template>


<script>
export default {

    //laravel側から定数を取得する
    computed: {
        constants(){ return this.$page.props.const; }
    },
}
</script>