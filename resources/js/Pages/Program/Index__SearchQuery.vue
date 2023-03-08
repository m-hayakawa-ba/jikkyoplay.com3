<template>

</template>


<script lang="ts">
import { defineComponent } from "vue";

import { SearchQuery } from "../../Interfaces/SearchQuery";

export default defineComponent({

    //呼び出し元から渡された引数
    props: [
        "queries",
    ],
    
});
</script>


<style lang="scss" scoped>
@import "@/sass/variables";

</style>