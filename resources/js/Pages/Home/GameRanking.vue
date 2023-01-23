<template>
    <h2>今週のランキング</h2>
    <section>
        <Link
            v-for="program in programs"
            class="program-item"
            :href="'/program/' + program.id"
        >
            <div class="program-image">
                <img
                    :src="program.image_url"
                    class="program-thumbnail"
                />
                <img
                    v-if="program.site_id == constants.site.youtube"
                    src="/image/logo_youtube.webp"
                    class="program-site-icon"
                >
                <img
                    v-if="program.site_id == constants.site.nikoniko"
                    src="/image/logo_nikoniko.webp"
                    class="program-site-icon"
                >
            </div>
        </Link>

        <!-- ランキング一覧へのリンク -->
        <PageLink
            href="/ranking"
            link_name="すべてのランキング"
        />
    </section>
</template>


<script>
import {usePage, Link} from "@inertiajs/inertia-vue3";
import PageLink from '../../Components/PageLink.vue';
export default {

    //コンポーネント内で使用する変数
    data() {
        return {
            programs: usePage().props.value.programs,
        };
    },

    //読み込んだコンポーネント
    components: {
        Link,
        PageLink,
    },

    //返り値が固定の関数
    computed: {

        //laravel側から定数を取得する
        constants() {
            return this.$page.props.const;
        },
    },

    //初回読み込み時に実行
    mounted() {
        console.log(this.programs);
    }
}
</script>


<style lang="scss" scoped>
@import "../../../sass/variables";

    section {
        margin-top: 4px;
        display: flex;
        flex-wrap: wrap;
        @media screen and (min-width: $bp) {
            padding-left: 8px;
        }
    }
    .program-item {
        margin: 6px 0;
        display: flex;
        flex-wrap: nowrap;
        align-items: center;
        width: 100%;
        cursor: pointer;
        @media screen and (min-width: $bp) {
            width: 50%;
        }
        &:hover {
            background-color: #d4f9ff;
            border-radius: 8px;
        }
    }
    .program-image {
        position: relative;
        width: 45%;
        padding: 4px 4px 4px 8px;
    }
    .program-thumbnail {
        aspect-ratio: 16 / 9;
        object-fit: cover;
        border-radius: 6px;
        box-shadow: 1px 1px 4px #20060654;
    }
    .program-site-icon {
        position: absolute;
        width: 22%;
        right: 3%;
        bottom: 3%;
    }

</style>