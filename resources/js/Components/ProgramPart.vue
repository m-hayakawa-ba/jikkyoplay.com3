<template>

    <!-- ランキング表示 -->
    <div
        v-if="rank"
        class="ranking-icon"
    >
        <img src="/image/ranking.webp">
        <div><span>{{ rank }}</span>位</div>
    </div>

    <!-- 再生回数 -->
    <div
        v-if="rank"
        class="program-view-count"
        style="padding-left: 72px;"
    >
        <span>{{ program.view_count.toLocaleString() }}</span> 回再生
    </div>
    <div
        v-else
        class="program-view-count"
        style="padding-left: 8px;"
    >
        <span>{{ program.view_count.toLocaleString() }}</span> 回再生
    </div>

    <!-- 番組情報 -->
    <Link
        class="program-item"
        :href="'/program/' + program.id"
    >
        <!-- 番組のサムネイル -->
        <ProgramThumbnail
            :thumbnail_url="program.image_url"
            :site_id="program.site_id"
            style="width: 45%;"
        />
        
        <div class="program-caption">
            <div class="program-text">
                {{ program.title }}
            </div>
            <div class="creater-data">
                <div class="creater-icon">
                    <img :src="program.user_icon_url" :alt="program.creater_name">
                </div>
                <div class="program-detail">
                    {{ program.creater_name }}<br>
                    {{ format(program.published_at) }} 投稿<br>
                </div>
            </div>
        </div>
    </Link>

</template>


<script>
import {Link} from "@inertiajs/inertia-vue3";
import moment from 'moment';
import ProgramThumbnail from "../Components/ProgramThumbnail.vue";
export default {

    //呼び出し元から渡された引数
    props: [
        "rank",     //ランキングがある場合、何位か（ランキングじゃない場合はnull）
        "program",  //動画情報
    ],

    //読み込んだコンポーネント
    components: {
        Link,
        ProgramThumbnail,
    },

    //コンポーネント内で使用するメソッド
    methods: {
        format(date) {
            return moment(date).format('YYYY年M月D日')
        }
    },

    //初回読み込み時に実行
    mounted() {
        // console.log(this.program);
    }
}
</script>


<style lang="scss" scoped>
@import "../../sass/variables";

    .ranking-icon {
        width: 60px;
        position: absolute;
        top: -8px;
        left: 8px;
        z-index: 1;
        div {
            position: absolute;
            top: 9px;
            left: 50%;
            font-size: $font-l;
            font-weight: bold;
            color: #462107;
            transform: translateX(-50%);
            span {
                font-size: $font-xl;
            }
        }
    }
    .program-view-count {
        font-weight: bold;
        color: #401409fc;
        span {
            font-size: $font-l;
        }
    }
    .program-item {
        margin: 0 0 6px;
        display: flex;
        flex-wrap: nowrap;
        align-items: center;
        width: 100%;
        cursor: pointer;
        &:hover {
            background-color: #d4f9ff;
            border-radius: 8px;
        }
    }
    .program-caption {
        width: 55%;
        padding: 4px 6px 4px 2px;
    }
    .program-text {
        font-weight: bold;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        overflow: hidden;
    }
    .creater-data {
        display: flex;
        align-items: center;
    }
    .creater-icon {
        width: 38px;
        border-radius: 50%;
        overflow: hidden;
        span {
            width: 58px;
        }
    }
    .program-detail {
        margin-left: 8px;
        font-size: $font-s;
    }
</style>