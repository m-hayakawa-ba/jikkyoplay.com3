<template>

    <!-- ゲーム情報 -->
    <div class="game-item">
        <table>
            <tr>
                <th>
                    ゲーム名：
                </th>
                <td>
                    {{ game.name }}
                </td>
            </tr>
            <tr>
                <th>
                    ハード：
                </th>
                <td>
                    {{ game.hard_name }}
                </td>
            </tr>
            <tr>
                <th>
                    メーカー：
                </th>
                <td>
                    {{ game.maker_name }}
                </td>
            </tr>
            <tr>
                <th>
                    発売年：
                </th>
                <td>
                    {{ game.releace_year }}年
                </td>
            </tr>
        </table>
    </div>

</template>


<script>
export default {

    //呼び出し元から渡された引数
    props: [
        "game",
    ],

//初回読み込み時に実行
    mounted() {
        console.log(this.game);
    }
}
</script>


<style lang="scss" scoped>
@import "@/sass/variables";
    .game-item {
        margin: 0 0 4px;
        padding: 2px;
        width: 100%;
        background-color: #fff;
        border: solid 1px #8b9699;
        border-radius: 4px;
        box-shadow: 1px 1px 2px #21003421;
    }

</style>