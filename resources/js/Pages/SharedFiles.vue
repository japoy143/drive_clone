<template>
    <AuthenticatedLayout>
        <!-- Heading -->
        <div class="flex justify-between mb-6">
            <h1 class="text-xl font-medium">Shared Files</h1>

            <div @click="onChangeListView">
                <ListBulletIcon v-if="is_list_view" class="size-6" />
                <Squares2X2Icon v-else class="size-6" />
            </div>
        </div>
        <!-- folders container -->
        <div
            class="flex relative h-[48px]"
            :class="[
                is_list_view
                    ? 'flex-col w-[200px] '
                    : 'flex-row flex-wrap gap-x-2',
            ]"
        >
            <div v-for="file in files" :key="file.id" class="mt-2">
                <Link
                    class="flex items-center justify-between h-[48px] p-2 w-[200px] border-2 border-black border-solid space-x-2 rounded"
                >
                    <div class="flex space-x-2">
                        <FolderIcon class="size-6" />
                        <p>{{ file.name }}</p>
                    </div>
                </Link>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref } from "vue";
import {
    ListBulletIcon,
    Squares2X2Icon,
    FolderIcon,
    StarIcon,
} from "@heroicons/vue/24/outline";
import AuthenticatedLayout from "../Layouts/AuthenticatedLayout.vue";

defineProps({
    files: Object,
});

const is_list_view = ref(false);

const onChangeListView = () => {
    is_list_view.value = !is_list_view.value;
    console.log(is_list_view);
};
</script>
