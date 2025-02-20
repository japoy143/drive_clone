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
            <div v-for="file in files" :key="file.id" class="mt-2">
                <Link
                    v-if="file.is_folder"
                    class="flex items-center justify-between h-[48px] p-2 w-[200px] border-2 border-black border-solid space-x-2 rounded"
                    :href="route('root.directory', file.name)"
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
                    <div>
                        <StarSolidIcon class="size-4" v-if="file.is_favorite" />
                    </div>
                </div>
                <!-- Floating Options -->
                <div
                    v-if="hoverIdHolder === file.id"
                    :key="file.id"
                    class="absolute w-[200px] px-4 py-2 space-y-2 bg-gray-100 z-100 shadow-md cursor-pointer"
                    :class="[is_list_view ? 'left-52' : 'mt-2']"
                    :style="is_list_view ? { top: `${folderPosition}px` } : {}"
                >
                    <p
                        class="hover:border-b-2"
                        @click="openModal(file.name, file.id)"
                    >
                        Rename
                    </p>
                    <Link
                        method="patch"
                        :href="route('favorite', file.id)"
                        class="hover:border-b-2"
                        >Favorite</Link
                    >
                    <p
                        @click="openShareUrlModal(file.path, file.id)"
                        class="hover:border-b-2"
                    >
                        Share
                    </p>
                    <Link
                        method="delete"
                        :href="route('delete.file', file.id)"
                        class="hover:border-b-2"
                    >
                        Delete
                    </Link>
                </div>
            </div>
        </div>

        <!-- Modal Here -->
        <RenameModal
            :isModalOpen="isModalOpen"
            :closeModal="closeModal"
            :fileName="fileName"
            :fileId="fileId"
        />
        <!-- Share File Modal -->
        <ShareUrlLinkModal
            :isModalOpen="isShareUrlModal"
            :closeModal="closeShareUrlModal"
            :urlLink="urlLink"
            :error="errorToast"
            :file_id="file_id"
        />
    </AuthenticatedLayout>
</template>

<script setup>
import {
    ListBulletIcon,
    Squares2X2Icon,
    FolderIcon,
    StarIcon,
    PhotoIcon,
    DocumentTextIcon,
} from "@heroicons/vue/24/outline";
import { StarIcon as StarSolidIcon } from "@heroicons/vue/20/solid";
import AuthenticatedLayout from "../Layouts/AuthenticatedLayout.vue";
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";
import RenameModal from "@/Components/app/RenameModal.vue";
import ShareUrlLinkModal from "@/Components/app/ShareUrlLinkModal.vue";
import { useToast } from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";

//props
const props = defineProps({
    files: Object,
});

//refs

let is_list_view = ref(true);
//mouser over id
const hoverIdHolder = ref(null);
//positions
const folderPosition = ref(0);
//modal refs
const fileName = ref("");
const fileId = ref("");
const isModalOpen = ref(false);

//extension type
const images = ["png", "jpg", "jpeg", "svg", "gif", "webp"];

//share url modal
const isShareUrlModal = ref(false);
const urlLink = ref("");
const file_id = ref("");

//toast
const toast = useToast();

//methods

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

const openModal = (name, id) => {
    isModalOpen.value = !isModalOpen.value;
    fileName.value = name;
    fileId.value = id;
};

const closeModal = () => {
    isModalOpen.value = false;
};

//shareUrl Modal Methods
const openShareUrlModal = (url, id) => {
    isShareUrlModal.value = true;
    urlLink.value = url;
    file_id.value = id;
};

const closeShareUrlModal = () => {
    isShareUrlModal.value = false;
};

const errorToast = () => {
    toast.error("Error endpoint api", {
        position: "top-right",
    });
};

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
