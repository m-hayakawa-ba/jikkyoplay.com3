<template>

    <!-- ヘッダー -->
    <Header />

    <main>
        <slot />
    </main>

    <!-- フッター -->
    <Footer />
    
</template>

<script>
import Header from "./Header.vue";
import Footer from "./Footer.vue";
export default {

    //読み込んだコンポーネント
    components: {
        Header,
        Footer,
    }

};
</script>