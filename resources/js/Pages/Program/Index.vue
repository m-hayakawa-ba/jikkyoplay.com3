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
                動画件数：{{ count.toLocaleString() }}件（{{ getProgramsStartBy() }}  ～ {{ getProgramsEndBy() }} 件）
            </div>

            <!-- 検索削除リンク -->
            <div class="link-tag-wrap">
                <LinkTag
                    v-for="(deletequery_link, index) in delete_query_links"
                    :key="index"
                    :name="deletequery_link.name"
                    :link="'/program?' + deletequery_link.query"
                    icon="cross"
                />
            </div>

            <!-- 並び順選択 -->
            <select
                class="sort-select"
                v-model="sort"
                @change="redirectNewSort"
            >
                <option value="date_desc">投稿日の新しい順</option>
                <option value="date_asc">投稿日の古い順</option>
                <option value="view_desc">再生数の多い順</option>
                <option value="view_asc">再生数の少ない順</option>
                <option value="year_desc">ゲーム発売年の新しい順</option>
                <option value="year_asc">ゲーム発売年の古い順</option>
            </select>

        </div>

        <!-- 動画一覧 -->
        <section>
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
        <Pagination
            :page_current="Number(queries.page)"
            :page_last="Number(page_last)"
            base_url="/program"
            :queries="queries"
        />

    </div>
</template>


<script lang="ts">
import { defineComponent } from "vue";

import { SearchQuery } from "../../Interfaces/SearchQuery";
import { SimpleProgram } from "../../Interfaces/Program";

import {usePage} from "@inertiajs/inertia-vue3";
import H2Title from "@/js/Components/H2Title.vue";
import LinkTag from "@/js/Components/LinkTag.vue";
import SearchLink from "../../Components/SearchLink.vue";
import ProgramWrap from '@/js/Components/Program/ProgramWrap.vue';
import Pagination from '@/js/Components/Pagination.vue';

interface QueryLink {
    name:  string,
    query: string,
}

export default defineComponent({

    //読み込んだコンポーネント
    components: {
        H2Title,
        LinkTag,
        ProgramWrap,
        Pagination,
        SearchLink,
    },

    //コンポーネント内で使用する変数
    data(): {
        count: number;
        programs: SimpleProgram[];
        page_last: number;
        programs_per_page: number;
        queries: SearchQuery;
        sort: string;
        delete_query_links : QueryLink[];
    } {
        return {
            count:              usePage().props.value.count as number,
            programs:           usePage().props.value.programs as SimpleProgram[],
            page_last:          usePage().props.value.page_last as number,
            programs_per_page:  usePage().props.value.programs_per_page as number,
            queries:            usePage().props.value.queries as SearchQuery,
            sort:               'date_desc',
            delete_query_links: usePage().props.value.delete_query_links as QueryLink[],
        };
    },

    //コンポーネント内で使用するメソッド
    methods: {
        
        //並び順を新しくしたとき画面を読み込み直す
        redirectNewSort() {

            //クエリを整理する
            var params = new URLSearchParams(this.queries);
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
                case 'year_desc':
                    params.set('sort', 'year');
                    params.set('order', 'desc');
                    break;
                case 'year_asc':
                    params.set('sort', 'year');
                    params.set('order', 'asc');
                    break;
            }

            //ソート順を変更してリダイレクト
            this.$inertia.get('/program' + '?' + params.toString());
        },

        //現在表示されている動画が何件目からかを取得
        getProgramsStartBy(): string {
            return ((Number(this.queries.page) - 1) * this.programs_per_page + 1).toLocaleString();
        },
        //現在表示されている動画が何件目までかを取得
        getProgramsEndBy(): string {
            return ((Number(this.queries.page) - 1) * this.programs_per_page + this.programs.length).toLocaleString();
        },
    },

    //初回読み込み時に実行
    mounted() {

        //渡されたクエリからソート順セレクトボックスの初期値を設定
        this.sort = this.queries.sort + '_' + this.queries.order;

        //SearchQueryの値を次々に取得し、検索条件を外すリンクを作成していく
        console.log(this.delete_query_links);
        
    }
    
});
</script>


<style lang="scss" scoped>
@import "@/sass/variables";
    .search-status {
        position: relative;
        margin: 10px 0 20px;
        width: 100%;
        justify-content: space-between;
        align-items: center;
        .sort-select {
            display: block;
            position: relative;
            padding: 4px 24px 4px 4px;
            border-radius: 8px;
            border: solid 1px #aaa;
            outline: 0;
            background-color: #fff;
            @media screen and (min-width: $bp) {
                position: absolute;
                top: 4px;
                right: 28px;
            }
        }
        @media screen and (min-width: $bp) {
            margin-left: 16px;
        }
        .link-tag-wrap {
            margin: 4px 0 12px;
            width: 100%;
            text-align: left;
        }
    }
    section {
        margin-top: 4px;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        @media screen and (min-width: $bp) {
            padding-left: 8px;
        }
    }
    .program-wrap {
        position: relative;
        margin-bottom: 12px;
        width: 100%;
        @media screen and (min-width: $bp) {
            margin: 0 0.166% 24px;
            width: 33%;
        }
    }
</style>