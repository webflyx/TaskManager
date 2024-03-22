<script setup>
import Header from "./UI/Header.vue";
</script>

<template>
    <Header :currentPage="$route.name" />
    <RouterView />
</template>

<style scoped>

</style>
