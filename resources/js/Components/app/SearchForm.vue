<template>
    <form class="w-[300px] absolute left-1/2 transform -translate-x-1/2">
        <input
            type="text"
            class="py-3 px-4 block w-full rounded-lg text-sm focus:border-white focus:ring-gray-200 disabled:opacity-50 disabled:pointer-events-none"
            placeholder="Search Files Here"
            v-model="search"
        />
    </form>
</template>

<script setup>
import { router, useForm, usePage } from "@inertiajs/vue3";
import axios from "axios";
import { debounce } from "lodash";
import { ref, watch } from "vue";

const search = ref("");

const page = usePage();
const splited_url = page.url.split("/");
watch(
    search,
    debounce((val) => {
        let url = "";
        switch (splited_url[1]) {
            case "myfiles":
                url = "/myfiles";
                break;
            case "directory":
                url = page.url;
                break;
            case "sharedfiles":
                url = "/sharedfiles";
                break;
            case "trash":
                url = "/trash";
                break;
            default:
                url = "/myfiles";
        }
        router.get(url, { search: val }, { preserveState: true });
    }),
    500
);

// watch(
//     search,
//     debounce(async (val) => {
//         if (!val) {
//             all_user.value = temp_container.value; // Clear users if input is empty
//             return;
//         }

//         try {
//             const response = await axios.get("/search/user/api", {
//                 params: { query: val },
//             });
//             all_user.value = response.data; // Update search results
//         } catch (error) {
//             console.error("Error fetching search results:", error);
//         }
//     }, 500) // Adjust debounce time
// );
</script>
