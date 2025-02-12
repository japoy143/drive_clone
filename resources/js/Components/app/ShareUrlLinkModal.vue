<template>
    <Modal :show="isModalOpen" maxWidth="md">
        <form class="px-2 py-2 flex">
            <input
                ref="folderInput"
                type="text"
                v-model="urlValue"
                placeholder="Rename File "
                readonly
                class="flex-1"
            />
            <button
                type="button"
                class="inline-flex rounded-tl-none rounded-bl-none justify-center rounded-md border border-transparent bg-black px-4 py-2 text-sm font-medium text-white hover:bg-black/70"
                @click="copyUrlToClipboard"
            >
                Copy Link
            </button>
        </form>
    </Modal>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import Modal from "../Modal.vue";
import { nextTick, ref, watch } from "vue";

const props = defineProps({
    isModalOpen: Boolean,
    closeModal: Function,
    urlLink: String,
});

const urlValue = ref("");

const copyUrlToClipboard = () => {
    try {
        navigator.clipboard.writeText(urlValue.value);
    } catch (error) {
        props.closeModal();
    } finally {
        props.closeModal();
    }
};

watch(
    () => props.urlLink,
    (newValue) => {
        urlValue.value = newValue;
    }
);
</script>
