<template>
    <div class="flex flex-row gap-4 h-screen w-full p-4">
        <!-- Side Navigation -->
        <div class="w-[200px]">
            <div class="flex items-center gap-2 font-medium">
                <FolderIcon class="size-8" />
                <h2>Free Drive</h2>
            </div>
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
        <Modal :show="isModalOpen" maxWidth="md">
            <form class="px-2 py-2 flex flex-col">
                <input
                    ref="folderInput"
                    type="text"
                    v-model="form.file"
                    placeholder="Enter File Name"
                />
                <div class="mt-2 flex justify-end space-x-2">
                    <button
                        type="button"
                        class="inline-flex justify-center rounded-md border border-transparent bg-black/20 px-4 py-2 text-sm font-medium text-black hover:bg-black hover:text-white"
                        @click="openNewFolderModal"
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        class="inline-flex justify-center rounded-md border border-transparent bg-black px-4 py-2 text-sm font-medium text-white hover:bg-black/70"
                        @click="saveFile"
                    >
                        Create
                    </button>
                </div>
            </form>
        </Modal>
    </div>
</template>

<script setup>
import { nextTick, ref } from "vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import CreateFolderDropdown from "../Components/app/CreateFolderDropdown.vue";
import { FolderIcon } from "@heroicons/vue/24/outline";
import Navigation from "../Components/app/Navigation.vue";
import Modal from "@/Components/Modal.vue";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    file: "",
});

const isModalOpen = ref(false);

//input focus
const folderInput = ref(null);

const openNewFolderModal = () => {
    isModalOpen.value = !isModalOpen.value;
    nextTick(() => {
        folderInput.value.focus();
    });
};

//save file
const saveFile = () => {
    form.post(route("savefile"));
};

//dropdown items
const dropDownItems = [
    {
        name: "New Folder",
        active: false,
        action: openNewFolderModal,
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
        action: () => {
            console.log("Upload File");
        },
    },
];
</script>
