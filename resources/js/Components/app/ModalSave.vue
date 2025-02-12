<template>
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
                    @click="openToCreateActions"
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
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import Modal from "../Modal.vue";
import { nextTick, ref, watch } from "vue";

// ✅ Make folderInput a local ref (not a prop)
const folderInput = ref(null);

const props = defineProps({
    isModalOpen: Boolean,
    openToCreateActions: Function,
    closeModal: Function,
    url: String,
    folderInput: ref,
});

const form = useForm({
    file: "",
    path: props.url,
});

//save file
const saveFile = () => {
    form.post(route("savefile"), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            props.closeModal();
        },
    });
};

// ✅ Watch when modal opens and focus the input
watch(
    () => props.isModalOpen,
    (newValue) => {
        if (newValue) {
            nextTick(() => {
                folderInput.value?.focus();
            });
        } else {
            folderInput.value?.blur();
        }
    }
);
</script>
