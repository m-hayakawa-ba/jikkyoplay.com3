<template>

    <div :id="id" class="h2-wrap">

        <!-- リンク先が渡されたときはリンクさせる -->
        <Link
            v-if="link_path"
            :href="link_path"
            class="h2-title"
        >
            <h2>
                {{ title_jp }}
                <div class="h2-link">
                    <div class="link-title pc-only">{{ link_title }}</div>
                    <div class="link-title sp-only">すべて見る</div>
                    <div class="link-svg"><SvgIcon icon="right" /></div>
                </div>
            </h2>
        </Link>

        <!-- リンク先がなかったときは普通のdivタグ -->
        <div
            v-else
            class="h2-title"
        >
            <h2>
                {{ title_jp }}
            </h2>
        </div>
    </div>

</template>

<script lang="ts">
import {Link} from "@inertiajs/inertia-vue3";
import SvgIcon from "@/js/Components/SvgIcon.vue";
export default {

    //呼び出し元から渡された引数
    props: [
        "id",
        "title_jp",
        "title_en",
        "link_title",
        "link_path",
    ],

    //読み込んだコンポーネント
    components: {
        Link,
        SvgIcon,
    },
}
</script>


<style lang="scss" scoped>
@import "../../sass/variables";
    .h2-wrap {
        padding-top: 66px;
        margin-top: -66px;
    }
    .h2-title {
        position: relative;
        left: -8px;
        display: block;
        margin: 10px auto 15px;
        padding: 10px 8px;
        width: calc(100% + 16px);
        background-color: #18100c;
        @media screen and (min-width: $bp) {
            left: 0px;
            width: 100%;
        }
        h2 {
            color: #fff;
            font-size: $font-l;
            font-weight: normal;
        }
        .h2-link {
            position: absolute;
            top: 10px;
            right: 8px;
            display: flex;
            .link-title {
                font-size: $font-s;
            }
            .link-svg {
                position: relative;
                bottom: 1px;
                margin-left: 4px;
                width: 22px;
                height: 22px;
            }
        }
    }
</style>