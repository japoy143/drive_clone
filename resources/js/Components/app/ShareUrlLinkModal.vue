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
                class="inline-flex justify-center rounded-none border-r-white border border-transparent bg-black px-4 py-2 text-sm font-medium text-white hover:bg-black/70"
                @click="openShareToInput"
            >
                Share To
            </button>
            <button
                type="button"
                class="inline-flex rounded-tl-none rounded-bl-none justify-center rounded-md border border-transparent bg-black px-4 py-2 text-sm font-medium text-white hover:bg-black/70"
                @click="copyUrlToClipboard"
            >
                Copy Link
            </button>
        </form>
        <!-- Share to input -->
        <form
            @submit.prevent="saveSample"
            v-if="isShareToOpen"
            class="w-full px-2 py-2"
        >
            <input
                ref="shareInputFocus"
                type="text"
                v-model="search"
                placeholder="Name of user "
                class="w-full"
            />
            <div class="mt-2 flex justify-end">
                <button
                    @click="shareToUserLink(search, file_id)"
                    :class="search !== '' ? 'bg-black' : 'bg-gray-400'"
                    class="inline-flex justify-center rounded-md border border-transparent bg-black px-4 py-2 text-sm font-medium text-white hover:bg-black/70"
                >
                    Share
                </button>
            </div>
            <div
                v-for="user in all_user"
                :key="user.id"
                class="w-full p-2 border-2 border-black mt-1 rounded-sm"
                @click="selectUser(user.email)"
            >
                <p>{{ user.email }}</p>
            </div>
        </form>
    </Modal>
</template>

<script setup>
import { router, useForm, usePage } from "@inertiajs/vue3";
import Modal from "../Modal.vue";
import { computed, nextTick, onMounted, ref, watch } from "vue";
import { throttle } from "lodash";
import { debounce } from "lodash";
import axios from "axios";
import { useToast } from "vue-toast-notification";

const props = defineProps({
    isModalOpen: Boolean,
    closeModal: Function,
    urlLink: String,
    file_id: {
        type: String,
        default: "",
    },
    error: Function,
});

//all user
const all_user = ref([]);

//temp all_user
const temp_container = ref([]);

//mounted
onMounted(async () => {
    try {
        const response = await axios.get("/users/api");
        all_user.value = response.data.data;
        temp_container.value = response.data.data;
    } catch (error) {
        props.error();
    }
});

//refs
const isShareToOpen = ref(false);
const shareInputFocus = ref(null);

const search = ref("");

const urlValue = ref("");

const toast = useToast();

const copyUrlToClipboard = () => {
    try {
        navigator.clipboard.writeText(urlValue.value);
    } catch (error) {
        props.closeModal();
    } finally {
        props.closeModal();
    }
};

const openShareToInput = () => {
    isShareToOpen.value = true;
};

watch(
    () => props.urlLink,
    (newValue) => {
        urlValue.value = newValue;
    }
);

watch(
    search,
    debounce(async (val) => {
        if (!val) {
            all_user.value = temp_container.value; // Clear users if input is empty
            return;
        }

        try {
            const response = await axios.get("/search/user/api", {
                params: { query: val },
            });
            all_user.value = response.data; // Update search results
        } catch (error) {
            console.error("Error fetching search results:", error);
        }
    }, 500) // Adjust debounce time
);

const selectUser = (val) => {
    search.value = val;
};

const saveSample = () => {};

const shareToUserLink = async (email, id) => {
    if (email === "") {
        toast.error("No Selected User", { position: "top-right" });
        props.closeModal();
        return;
    }
    try {
        const res = await axios.post(`/shared/file/${email}/${id}`);
        search.value = "";
        copyUrlToClipboard();
        toast.success("copy link to clipboard", {
            position: "top-right",
        });
    } catch (error) {
        console.log(error);
    }
};
// const filteredUsers = computed(() => {
//     return props.searchUser.filter((user) =>
//         user.name.toLowerCase().includes(search.value.toLowerCase())
//     );
// });
</script>
