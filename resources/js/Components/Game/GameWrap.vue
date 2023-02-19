<template>

    <!-- ゲーム情報 -->
    <div class="game-item">
        <table>
            <tr>
                <th>
                    ゲーム名：
                </th>
                <td>
                    <Link
                        :href="'/program?game_id=' + game.id"
                        class="link-flex"
                    >
                        {{ game.name }}
                        <div class="svg_icon">
                            <SvgIcon icon="right" size="24px" />
                        </div>
                    </Link>
                </td>
            </tr>
            <tr>
                <th>
                    ハード：
                </th>
                <td>
                    <Link
                        :href="'/program?hard_id=' + game.hard_id"
                        class="link-flex"
                    >
                        {{ game.hard_name }}
                        <div class="svg_icon">
                            <SvgIcon icon="right" />
                        </div>
                    </Link>
                </td>
            </tr>
            <tr>
                <th>
                    メーカー：
                </th>
                <td>
                    <Link
                        :href="'/program?maker_id=' + game.maker_id"
                        class="link-flex"
                    >
                        {{ game.maker_name }}
                        <div class="svg_icon">
                            <SvgIcon icon="right" />
                        </div>
                    </Link>
                </td>
            </tr>
            <tr>
                <th>
                    発売年：
                </th>
                <td>
                    <Link
                        :href="'/program?year=' + game.releace_year"
                        class="link-flex"
                    >
                        {{ game.releace_year }}年
                        <div class="svg_icon">
                            <SvgIcon icon="right" />
                        </div>
                    </Link>
                </td>
            </tr>
        </table>
    </div>

</template>


<script>
import {Link} from "@inertiajs/inertia-vue3";
import SvgIcon from "@/js/Components/SvgIcon.vue";
export default {

    //呼び出し元から渡された引数
    props: [
        "game",
    ],

    //読み込んだコンポーネント
    components: {
        Link,
        SvgIcon,
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
        padding: 2px;
        width: 100%;
        background-color: #fff;
        border: solid 1px #8b9699;
        border-radius: 4px;
        box-shadow: 1px 1px 2px #21003421;
    }
    th {
        font-weight: normal;
    }
    .link-flex {
        display: flex;
        color: $font-color-link;
        font-weight: bold;
    }
    .svg_icon {
        width: 20px;
        height: 20px;
        margin-left: 2px;
    }

</style>