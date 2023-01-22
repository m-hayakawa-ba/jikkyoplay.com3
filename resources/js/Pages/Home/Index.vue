<template>

    <!-- 検索ワード -->
    <SearchItem />

    <!-- サイト本体部分 -->
    <div class="inner">
        
        <!-- ゲーム実況ニュース -->
        <GameNews />

    </div>

</template>

<script>
import SearchItem from "./SearchItem.vue";
import GameNews from "./GameNews.vue";
export default {

    //読み込んだコンポーネント
    components: {
        SearchItem,
        GameNews,
    },
};
</script>