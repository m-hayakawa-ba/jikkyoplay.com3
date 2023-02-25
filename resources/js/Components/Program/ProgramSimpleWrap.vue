<template>
    <InformationWrap>
        <table>
            <tr>
                <th>
                    掲載元サイト：
                </th>
                <td>
                    <SearchLink
                        :name="site_name"
                        :query="'site_id=' + site_id"
                    />
                </td>
            </tr>
            <tr>
                <th>
                    音声　　　　：
                </th>
                <td>
                    <SearchLink
                        :name="voice_type"
                        :query="'voice_id=' + voice_id"
                    />
                </td>
            </tr>
        </table>
    </InformationWrap>
</template>


<script>
import InformationWrap from "@/js/Components/Information/InformationWrap.vue";
import SearchLink      from "@/js/Components/SearchLink.vue";
export default {

    //呼び出し元から渡された引数
    props: [
        "site_id",
        "site_name",
        "voice_id",
        "voice_type",
    ],

    //読み込んだコンポーネント
    components: {
        InformationWrap,
        SearchLink,
    },
}
</script>


<style lang="scss" scoped>
@import "@/sass/variables";

</style>