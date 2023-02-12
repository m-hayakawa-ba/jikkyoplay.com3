<template>

    <!-- サイト本体部分 -->
    <div class="inner">
        
        <!-- 今週のランキング -->
        <H2Title
            title_jp="ゲーム実況動画一覧"
            title_en="GAMEPLAY PROGRAMS"
        />

        <!-- 動画の総数 -->
        <div class="search-status">

            <!-- ヒット数 -->
            <div>
                検索項目<br class="sp-only">（ヒット数：{{ count.toLocaleString() }}）
            </div>

            <!-- 並び順選択 -->
            <select v-model="sort" @change="redirectNewSort">
                <option value="date_desc">投稿日の新しい順</option>
                <option value="date_asc">投稿日の古い順</option>
                <option value="view_desc">再生数の多い順</option>
                <option value="view_asc">再生数の少ない順</option>
                <option value="sale_desc">ゲーム発売年の新しい順</option>
                <option value="sale_asc">ゲーム発売年の古い順</option>
            </select>
        </div>


        <section>

            <!-- 動画一覧 -->
            <div
                v-for="program in programs"
                :key="program.id"
                class="program-wrap"
            >
                <ProgramWrap
                    :rank="null"
                    :program="program"
                />   
            </div>
        </section>

        <!-- ページネーション -->
        <PageList
            :page_current="Number(queries.page)"
            :page_last="Number(page_last)"
            base_url="/program"
            :queries="queries"
        />

    </div>
</template>


<script>
import {usePage} from "@inertiajs/inertia-vue3";
import H2Title from "@/js/Components/H2Title.vue";
import ProgramWrap from '@/js/Components/Program/ProgramWrap.vue';
import PageList from '@/js/Components/PageList.vue';
export default {

    //読み込んだコンポーネント
    components: {
        H2Title,
        ProgramWrap,
        PageList,
    },

    //コンポーネント内で使用する変数
    data() {
        return {
            count:        usePage().props.value.count,
            programs:     usePage().props.value.programs,
            page_last:    usePage().props.value.page_last,
            queries:      usePage().props.value.queries,
            sort:         'date_desc',
        };
    },

    //コンポーネント内で使用するメソッド
    methods: {
        
        //並び順を新しくしたとき画面を読み込み直す
        redirectNewSort() {

            //クエリを整理する
            var params = new URLSearchParams(this.queries);
            params.set('page', 1);
            switch(this.sort) {
                case 'date_desc':
                    params.set('sort', 'date');
                    params.set('order', 'desc');
                    break;
                case 'date_asc':
                    params.set('sort', 'date');
                    params.set('order', 'asc');
                    break;
                case 'view_desc':
                    params.set('sort', 'view');
                    params.set('order', 'desc');
                    break;
                case 'view_asc':
                    params.set('sort', 'view');
                    params.set('order', 'asc');
                    break;
                case 'sale_desc':
                    params.set('sort', 'sale');
                    params.set('order', 'desc');
                    break;
                case 'sale_asc':
                    params.set('sort', 'sale');
                    params.set('order', 'asc');
                    break;
            }

            //ソート順を変更してリダイレクト
            this.$inertia.visit('/program' + '?' + params.toString(), {
                method: 'get',
            });
        },
    },

    //初回読み込み時に実行
    mounted() {

        //渡されたクエリからソート順セレクトボックスの初期値を設定
        this.sort = this.queries.sort + '_' + this.queries.order;
    }
    
}
</script>


<style lang="scss" scoped>
@import "@/sass/variables";
    .search-status {
        margin: 10px 0 5px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        select {
            display: block;
            position: relative;
            padding: 4px 24px 4px 4px;
            border-radius: 8px;
            border: solid 1px #aaa;
            outline: 0;
            background-color: #fff;
        }
        @media screen and (min-width: $bp) {
            margin-left: 16px;
        }
    }
    section {
        margin-top: 4px;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        @media screen and (min-width: $bp) {
            padding-left: 8px;
        }
    }
    .program-wrap {
        position: relative;
        margin: 8px 0 0;
        width: 100%;
        @media screen and (min-width: $bp) {
            width: 49%;
        }
    }
</style>