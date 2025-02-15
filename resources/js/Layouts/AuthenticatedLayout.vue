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

        <main class="flex-1">
            <Navigation />
            <slot />
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
import { nextTick, ref } from "vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import CreateFolderDropdown from "../Components/app/CreateFolderDropdown.vue";
import { FolderIcon } from "@heroicons/vue/24/outline";
import Navigation from "../Components/app/Navigation.vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";
import uploadFileModal from "@/Components/app/uploadFileModal.vue";
//ignore
import SaveModal from "@/Components/app/ModalSave.vue";

const url = decodeURIComponent(usePage().url);

const isModalOpen = ref(false);
const isUploadFileModalOpen = ref(false);

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
</script>
