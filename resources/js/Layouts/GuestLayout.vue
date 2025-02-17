<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { FolderIcon } from "@heroicons/vue/24/outline";
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <div
        class="flex min-h-screen flex-col items-center bg-white pt-6 sm:justify-center sm:pt-0"
    >
        <div>
            <Link href="/" class="flex items-center gap-2">
                <FolderIcon class="size-10" />
                <h1 class="text-2xl font-medium">Free Drive</h1>
            </Link>
        </div>

        <div class="md:w-[600px]">
            <slot />
        </div>
    </div>
</template>
