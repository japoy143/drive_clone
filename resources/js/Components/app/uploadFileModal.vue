<template>
    <Modal :show="isModalOpen" maxWidth="md">
        <form class="px-4 py-4 flex flex-col" @submit.prevent="uploadFile">
            <input type="file" @input="form.file = $event.target.files[0]" />
            <div class="mt-2 flex justify-end space-x-2">
                <button
                    type="button"
                    class="inline-flex justify-center rounded-md border border-transparent bg-black/20 px-4 py-2 text-sm font-medium text-black hover:bg-black hover:text-white"
                    @click="closeModal"
                >
                    Cancel
                </button>
                <button
                    type="submit"
                    class="inline-flex justify-center rounded-md border border-transparent bg-black px-4 py-2 text-sm font-medium text-white hover:bg-black/70"
                >
                    Upload
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
});

const form = useForm({
    file: null,
});

//save file
const uploadFile = () => {
    form.post(route("upload.file"), {
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
