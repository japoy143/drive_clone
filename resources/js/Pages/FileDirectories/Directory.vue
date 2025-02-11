<template>
    <AuthenticatedLayout>
        <h1 class="text-xl font-medium">{{ path }}</h1>

        <div
            class="flex"
            :class="[is_list_view ? 'flex-col' : 'flex-row flex-wrap gap-x-2']"
        >
            <a
                v-for="file in files"
                :key="file.id"
                :href="route('directory', file.name)"
                class="mt-2"
            >
                <div
                    class="flex p-3 w-[200px] border-2 border-black border-solid space-x-2 rounded"
                >
                    <FolderIcon class="size-6" />
                    <p>{{ file.name }}</p>
                </div>
            </a>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

defineProps({
    path: String,
    files: Object,
});
</script>
