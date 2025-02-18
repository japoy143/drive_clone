<template>
    <nav
        class="w-full flex items-center gap-4 lg:px-0 lg:gap-0 justify-between relative mb-2"
    >
        <SearchForm />
        <UserSettings />
    </nav>
</template>

<script setup>
import SearchForm from "../app/SearchForm.vue";
import UserSettings from "../app/UserSettings.vue";
</script>
