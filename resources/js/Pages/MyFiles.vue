<template>
    <AuthenticatedLayout>
        <div class="flex justify-between mb-6">
            <h1 class="text-xl font-medium">My Files</h1>

            <div @click="onChangeListView">
                <ListBulletIcon v-if="is_list_view" class="size-6" />
                <Squares2X2Icon v-else class="size-6" />
            </div>
        </div>
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
import {
    ListBulletIcon,
    Squares2X2Icon,
    FolderIcon,
} from "@heroicons/vue/24/outline";
import AuthenticatedLayout from "../Layouts/AuthenticatedLayout.vue";

defineProps({
    files: Object,
});

import { ref } from "vue";

let is_list_view = ref(true);

const onChangeListView = () => {
    is_list_view.value = !is_list_view.value;
    console.log(is_list_view);
};
</script>
