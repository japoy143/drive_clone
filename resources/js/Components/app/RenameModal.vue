<template>
    <Modal :show="isModalOpen" maxWidth="md">
        <form class="px-2 py-2 flex flex-col">
            <input
                ref="folderInput"
                type="text"
                v-model="form.fileName"
                placeholder="Rename File "
            />
            <div class="mt-2 flex justify-end space-x-2">
                <button
                    type="button"
                    class="inline-flex justify-center rounded-md border border-transparent bg-black/20 px-4 py-2 text-sm font-medium text-black hover:bg-black hover:text-white"
                    @click="closeModal"
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
    closeModal: Function,
    fileName: String,
    fileId: String,
});

const form = useForm({
    fileName: props.fileName,
    path: props.url,
});

//save file
const saveFile = () => {
    form.post(route("rename", props.fileId), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
            props.closeModal();
        },
    });
};

//  Watch when modal opens and focus the input
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

// Sync prop update to form input
watch(
    () => props.fileName,
    (newName) => {
        form.fileName = newName;
    }
);
</script>
