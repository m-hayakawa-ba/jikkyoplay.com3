<!-- 動画情報や実況者情報などの囲み枠 -->
<!-- hrefの中身によって内部リンクになったり外部リンクになったり、ただのdivになったりする -->

<template>

    <!-- リンクじゃないとき -->
    <div
        v-if="checkLink() == 'div'"
        class="information-item"
    ><slot></slot></div>

    <!-- 外部リンクのとき -->
    <a
        v-else-if="checkLink() == 'a'"
        :href="href"
        class="information-item information-link"
        target="_blank"
    ><slot></slot></a>

    <!-- 内部リンクのとき -->
    <Link
        v-else
        :href="href"
        class="information-item information-link"
    ><slot></slot></Link>
    
</template>


<script>
import {Link} from "@inertiajs/inertia-vue3";
export default {

    //呼び出し元から渡された引数
    props: [
        "href",     //外部・内部リンク
    ],

    //読み込んだコンポーネント
    components: {
        Link,
    },

    //コンポーネント内で使用するメソッド
    methods: {

        //渡されたhrefの内容でタグを変更する
        checkLink() {

            //hrefがなかったときはdivタグにする
            if (!this.href) {
                return 'div';
            }

            //外部リンクのときはaタグにする
            else if (this.href.indexOf('http://') > 0 || this.href.indexOf('https://') > 0) {
                return 'a';
            }

            //それ以外のときはLinkタグにする
            else {
                return 'Link';
            }
        }
    },
}
</script>


<style lang="scss" scoped>
@import "@/sass/variables";
    .information-item {
        margin: 0;
        padding: 2px;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        width: 100%;
        background-color: #fff;
        border: solid 1px #8b9699;
        border-radius: 4px;
        box-shadow: 1px 1px 2px #21003421;
    }
    .information-link {
        &:hover {
            background-color: #d4f9ff;
            border-radius: 8px;
        }
    }
</style>