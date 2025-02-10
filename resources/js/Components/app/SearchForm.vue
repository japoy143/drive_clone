<template>
    <form
        action=""
        class="w-[300px] absolute left-1/2 transform -translate-x-1/2"
    >
        <input
            type="text"
            class="py-3 px-4 block w-full rounded-lg text-sm focus:border-white focus:ring-gray-200 disabled:opacity-50 disabled:pointer-events-none"
            placeholder="Search Files Here"
        />
    </form>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    search: "",
});
</script>
