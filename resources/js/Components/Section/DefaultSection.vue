<template>
    <section class="default-section">
        <slot></slot>
    </section>
</template>

<style lang="scss" scoped>
@import "@/sass/variables";
    .default-section {
        margin: 0 0 40px;
        display: flex;
        flex-wrap: wrap;
        justify-content: flex-start;
    }
</style>