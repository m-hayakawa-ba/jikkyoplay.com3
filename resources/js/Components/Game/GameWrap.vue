<template>

    <!-- ゲーム情報 -->
    <div class="game-item">
        <table>
            <tr>
                <th>
                    ゲーム名：
                </th>
                <td>
                    <SearchLink
                        :name="game.name"
                        :query="'game_id=' + game.id"
                    />
                </td>
            </tr>
            <tr>
                <th>
                    ハード　：
                </th>
                <td>
                    <SearchLink
                        :name="game.hard_name"
                        :query="'hard_id=' + game.hard_id"
                    />
                </td>
            </tr>
            <tr>
                <th>
                    メーカー：
                </th>
                <td>
                    <SearchLink
                        :name="game.maker_name"
                        :query="'maker_id=' + game.maker_id"
                    />
                </td>
            </tr>
            <tr>
                <th>
                    発売年　：
                </th>
                <td>
                    <SearchLink
                        :name="game.releace_year + '年'"
                        :query="'year=' + game.releace_year"
                    />
                </td>
            </tr>
        </table>
    </div>

</template>


<script>
import SearchLink from "@/js/Components/SearchLink.vue";
export default {

    //呼び出し元から渡された引数
    props: [
        "game",
    ],

    //読み込んだコンポーネント
    components: {
        SearchLink,
    },

    //初回読み込み時に実行
        mounted() {
            // console.log(this.game);
        }
    }
</script>


<style lang="scss" scoped>
@import "@/sass/variables";
    .game-item {
        margin: 0 0 4px;
        padding: 2px 12px;
        width: 100%;
        background-color: #fff;
        border: solid 1px #8b9699;
        border-radius: 4px;
        box-shadow: 1px 1px 2px #21003421;
    }
    th {
        min-width: 72px;
        white-space: nowrap;
        font-weight: normal;
    }
    td {
        padding: 1px 0;
    }

</style>