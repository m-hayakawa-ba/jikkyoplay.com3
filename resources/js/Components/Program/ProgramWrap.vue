<template>

    <!-- 再生回数表示 -->
    <ProgramViewCount
        :rank="rank"
        :view_count="program.view_count"
    />

    <!-- 番組情報 -->
    <Link
        class="program-item"
        :href="'/program/' + program.id"
    >
        <!-- 番組のサムネイル -->
        <ProgramThumbnail
            :thumbnail_url="program.image_url"
            :site_id="program.site_id"
            style="width: 50%;"
        />

        <!-- 番組情報 -->
        <ProgramCaption
            :title="program.title"
            :creater_name="program.creater_name"
            :creater_icon_url="program.user_icon_url"
            :published_at="program.published_at"
            style="width: 50%;"
        />
    </Link>

</template>


<script>
import {Link} from "@inertiajs/inertia-vue3";
import ProgramViewCount from "@/js/Components/Program/ProgramViewCount.vue";
import ProgramThumbnail from "@/js/Components/Program/ProgramThumbnail.vue";
import ProgramCaption from "@/js/Components/Program/ProgramCaption.vue";
export default {

    //呼び出し元から渡された引数
    props: [
        "rank",     //ランキングがある場合、何位か（ランキングじゃない場合はnull）
        "program",  //動画情報
    ],

    //読み込んだコンポーネント
    components: {
        Link,
        ProgramViewCount,
        ProgramThumbnail,
        ProgramCaption,
    },

    //初回読み込み時に実行
    mounted() {
        // console.log(this.program);
    }
}
</script>


<style lang="scss" scoped>
@import "@/sass/variables";

    .program-item {
        margin: 0;
        padding: 2px;
        display: flex;
        flex-wrap: nowrap;
        align-items: center;
        width: 100%;
        background-color: #fff;
        border: solid 1px #8b9699;
        border-radius: 4px;
        box-shadow: 1px 1px 2px #21003421;
        cursor: pointer;
        &:hover {
            background-color: #d4f9ff;
            border-radius: 8px;
        }
    }
</style>