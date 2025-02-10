<template>
    <AuthenticatedLayout>
        <h1 class="text-xl font-medium">{{ path }}</h1>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

defineProps({
    path: String,
});
</script>
