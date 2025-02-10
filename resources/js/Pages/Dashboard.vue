<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="flex justify-end">
            <div @click="onChangeListView">
                <ListBulletIcon v-if="is_list_view" class="size-6" />
                <Squares2X2Icon v-else class="size-6" />
            </div>
        </div>
        <div>Dashboard</div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ListBulletIcon, Squares2X2Icon } from "@heroicons/vue/24/outline";
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";

let is_list_view = ref(true);

const onChangeListView = () => {
    is_list_view.value = !is_list_view.value;
    console.log(is_list_view);
};
</script>
