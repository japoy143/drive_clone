<template>
    <AuthenticatedLayout @click="closeHoverId">
        <div class="flex justify-between mb-6">
            <h1 class="text-xl font-medium">Shared Files</h1>

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
            <!-- Folder Container -->
            <div v-for="file in files" :key="file.id" class="mt-2">
                <Link
                    v-if="file.is_folder"
                    class="flex items-center justify-between h-[48px] p-2 w-[200px] border-2 border-black border-solid space-x-2 rounded"
                    @mouseover="onChangeHoverId($event, file.id)"
                >
                    <div class="flex space-x-2">
                        <FolderIcon class="size-6" />
                        <p>{{ file.name }}</p>
                    </div>
                    <div>
                        <StarSolidIcon class="size-6" v-if="file.is_favorite" />
                    </div>
                </Link>
                <!-- if file, file container -->
                <div
                    v-else
                    @mouseover="onChangeHoverId($event, file.id)"
                    class="flex gap-2"
                >
                    <PhotoIcon v-if="hasImage(file.mime)" class="size-6" />
                    <DocumentTextIcon v-else class="size-6" />
                    <p>{{ limitedLetters(file.name, file.mime, file.id) }}</p>
                </div>
                <!-- Floating Options -->
                <div
                    v-if="hoverIdHolder === file.id"
                    :key="file.id"
                    class="absolute w-[200px] px-4 py-2 space-y-2 bg-gray-100 z-100 shadow-md cursor-pointer"
                    :class="[is_list_view ? 'left-52' : 'mt-2']"
                    :style="is_list_view ? { top: `${folderPosition}px` } : {}"
                >
                    <Link
                        method="post"
                        class="hover:border-b-2"
                        :href="route('unshare.file', file.id)"
                    >
                        Unshare
                    </Link>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "../Layouts/AuthenticatedLayout.vue";
import {
    ListBulletIcon,
    Squares2X2Icon,
    FolderIcon,
    PhotoIcon,
    DocumentTextIcon,
} from "@heroicons/vue/24/outline";

import { Link, usePage } from "@inertiajs/vue3";

import { ref, watch } from "vue";
import RenameModal from "@/Components/app/RenameModal.vue";
import { StarIcon as StarSolidIcon } from "@heroicons/vue/20/solid";
import { useToast } from "vue-toast-notification";
import axios from "axios";

//props

const props = defineProps({ files: Object });

//toast
const toast = useToast();

//refs

let is_list_view = ref(true);

//mouser over id
const hoverIdHolder = ref(null);
//positions
const folderPosition = ref(0);
//extension type
const images = ["png", "jpg", "jpeg", "svg", "gif", "webp"];

//methods
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

const closeHoverId = () => {
    hoverIdHolder.value = null;
};

const page = usePage();

//watch status
watch(
    () => page.props.flash.message,
    (newValue) => {
        if (newValue) {
            console.log(newValue);
            toast.success("Successfully Unshared File", {
                position: "top-right",
            });

            // Clear flash message after showing toast
            page.props.flash.message = null;
        }
    }
);

const hasImage = (image) => {
    return images
        .map((item) => item.toLowerCase())
        .includes(image.toLowerCase());
};

const limitedLetters = (words, extension, id) => {
    const letterCount = 15;
    const splittedWords = words.split("");
    let joinWord = "";
    if (splittedWords.length >= 15) {
        for (let i = 0; i < letterCount; i++) {
            joinWord += splittedWords[i];
        }

        joinWord += id;
        joinWord += ".";
        joinWord += extension;

        return joinWord;
    } else {
        joinWord += words;
        joinWord += ".";
        joinWord += extension;

        return joinWord;
    }
};
</script>
