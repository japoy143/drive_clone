<template>
    <div class="flex flex-row gap-4 h-screen w-full p-4">
        <!-- Side Navigation -->
        <div class="w-[200px]">
            <Link
                :href="route('dashboard')"
                class="flex items-center gap-2 font-medium"
            >
                <FolderIcon class="size-8" />
                <h2>Free Drive</h2>
            </Link>
            <div class="mt-4 space-y-2 flex flex-col">
                <CreateFolderDropdown
                    dropDownName="Create Folder"
                    :menuItems="dropDownItems"
                />

                <ResponsiveNavLink :href="route('myfiles')"
                    >My Files</ResponsiveNavLink
                >
                <ResponsiveNavLink :href="route('sharedfiles')"
                    >Shared Files</ResponsiveNavLink
                >
                <ResponsiveNavLink :href="route('trash')"
                    >Trash</ResponsiveNavLink
                >
            </div>
        </div>

        <main
            @drop.prevent="handleDrop"
            @dragover.prevent="onDragOver"
            @dragleave.prevent="onDragLeave"
            class="flex-1"
        >
            <Navigation />
            <div
                v-if="dragOver"
                class="flex flex-col justify-center items-center h-full border-dashed border-black border-2"
            >
                <h1 class="text-3xl mb-4 font-medium">Drag files here</h1>
                <DocumentIcon class="size-20" />
            </div>
            <slot v-else />
            <loading :active="isLoading" :is-full-page="true"></loading>
        </main>
        <!-- Modal Here -->
        <SaveModal
            :isModalOpen="isModalOpen"
            :openToCreateActions="openToCreateNewFolderModal"
            :url="url"
            :closeModal="closeModal"
        />
        <!-- Upload File Modal -->
        <uploadFileModal
            :isModalOpen="isUploadFileModalOpen"
            :openToCreateActions="openUploadFileModal"
            :closeModal="closeUploadFileModal"
        />
    </div>
</template>

<script setup>
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/css/index.css";
import { nextTick, onMounted, ref } from "vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import CreateFolderDropdown from "../Components/app/CreateFolderDropdown.vue";
import { FolderIcon, DocumentIcon } from "@heroicons/vue/24/outline";
import Navigation from "../Components/app/Navigation.vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";
import uploadFileModal from "@/Components/app/uploadFileModal.vue";

//ignore
import SaveModal from "@/Components/app/ModalSave.vue";
import { emitter, FILE_UPLOAD_STARTED } from "@/event-bus";

const url = decodeURIComponent(usePage().url);

const isModalOpen = ref(false);
const isUploadFileModalOpen = ref(false);
const isLoading = ref(false);

const fileUploadForm = useForm({
    files: [],
    path: url,
});

const page = usePage();

//drag drop
const dragOver = ref(false);

const openToCreateNewFolderModal = () => {
    isModalOpen.value = !isModalOpen.value;
};

const openUploadFileModal = () => {
    isUploadFileModalOpen.value = true;
};

const closeUploadFileModal = () => {
    isUploadFileModalOpen.value = false;
};

const closeModal = () => {
    isModalOpen.value = false;
};

//dropdown items
const dropDownItems = [
    {
        name: "New Folder",
        active: false,
        action: openToCreateNewFolderModal,
    },
    {
        name: "Upload Folder",
        active: false,
        action: () => {
            console.log("Upload Folder");
        },
    },
    {
        name: "Upload File",
        active: false,
        action: openUploadFileModal,
    },
];

const uploadFiles = (files) => {
    fileUploadForm.files = files;
    isLoading.value = true;
    fileUploadForm.post(route("upload.file"), {
        onSuccess: () => {
            isLoading.value = false;
        },
        preserveState: true,
    });
};

function onDragOver() {
    dragOver.value = true;
}

function onDragLeave() {}
const handleDrop = (event) => {
    dragOver.value = false;
    const files = event.dataTransfer.files;
    if (!files.length) {
        return;
    }

    uploadFiles(files);
};

onMounted(() => {
    emitter.on(FILE_UPLOAD_STARTED, uploadFiles);
});
</script>
