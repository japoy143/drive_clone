<template>
    <AuthenticatedLayout @click="closeHoverId">
        <div class="flex justify-between mb-6">
            <h1 class="text-xl font-medium">My Files</h1>

            <div @click="onChangeListView">
                <ListBulletIcon v-if="is_list_view" class="size-6" />
                <Squares2X2Icon v-else class="size-6" />
            </div>
        </div>
        <div
            class="flex relative h-[48px]"
            :class="[
                is_list_view
                    ? 'flex-col w-[200px] '
                    : 'flex-row flex-wrap gap-x-2',
            ]"
        >
            <Link
                v-for="file in files"
                :key="file.id"
                :href="route('directory', file.name)"
                class="mt-2"
            >
                <div
                    class="flex items-center h-[48px] p-2 w-[200px] border-2 border-black border-solid space-x-2 rounded"
                    @mouseover="onChangeHoverId($event, file.id)"
                >
                    <FolderIcon class="size-6" />
                    <p>{{ file.name }}</p>
                </div>
                <div
                    v-if="hoverIdHolder === file.id"
                    :key="file.id"
                    class="absolute w-[200px] px-4 py-2 space-y-2 bg-gray-100 z-100 shadow-md"
                    :class="[is_list_view ? 'left-52' : 'mt-2']"
                    :style="is_list_view ? { top: `${folderPosition}px` } : {}"
                >
                    <p>Rename</p>
                    <p>Favorite</p>
                    <p>Share</p>
                    <p>Delete</p>
                </div>
            </Link>
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
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";
defineProps({
    files: Object,
});

let is_list_view = ref(true);

//mouser over id
const hoverIdHolder = ref(null);

//positions
const folderPosition = ref(0);

const closeHoverId = () => {
    hoverIdHolder.value = null;
};

const onChangeHoverId = (event, id) => {
    const rect = event.target.getBoundingClientRect();
    hoverIdHolder.value = id;
    if (is_list_view) {
        folderPosition.value = rect.top - 80;
    }
};

const onChangeListView = () => {
    is_list_view.value = !is_list_view.value;
    console.log(is_list_view);
};
</script>
