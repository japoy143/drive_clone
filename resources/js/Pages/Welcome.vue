<script setup>
import { FolderIcon } from "@heroicons/vue/24/outline";
import { Head, Link } from "@inertiajs/vue3";
import DatabaseImage from "../../imgs/database_server.svg";

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

function handleImageError() {
    document.getElementById("screenshot-container")?.classList.add("!hidden");
    document.getElementById("docs-card")?.classList.add("!row-span-1");
    document.getElementById("docs-card-content")?.classList.add("!flex-row");
    document.getElementById("background")?.classList.add("!hidden");
}
</script>

<template>
    <Head title="Welcome" />
    <div class="flex flex-col h-screen">
        <nav class="px-10 py-4 flex items-center justify-between">
            <div class="flex items-center gap-2 font-medium">
                <FolderIcon class="size-8" />
                <h1>Free Drive</h1>
            </div>

            <div v-if="canLogin" class="">
                <Link
                    v-if="$page.props.auth.user"
                    :href="route('dashboard')"
                    class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                >
                    Dashboard
                </Link>

                <template v-else>
                    <Link
                        :href="route('login')"
                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                    >
                        Log in
                    </Link>

                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                    >
                        Register
                    </Link>
                </template>
            </div>
        </nav>

        <div class="flex-1 grid grid-cols-2 px-10">
            <div class="flex flex-col font-medium pt-32 px-20">
                <div>
                    <h1 class="text-4xl mb-2 font-bold">
                        Where Your Files Feel at Home
                    </h1>

                    <p>
                        Effortlessly store, access, and share your files from
                        anywhere with our secure and intuitive cloud platform.
                        Enjoy seamless collaboration, unlimited storage
                        potential, and total control over your digital world.
                    </p>
                </div>

                <div class="mt-4 flex">
                    <button
                        class="bg-black p-2 text-white rounded font-medium px-4"
                    >
                        Create Account Now
                    </button>
                </div>

                <div class="mt-4 grid grid-cols-6">
                    <div
                        class="col-span-3 border border-t-0 border-l-0 border-gray-300 border-solid p-4"
                    >
                        <h1 class="text-2xl font-bold">1GB</h1>
                        <p>Free Fast Storage</p>
                        <p>Secure and fast</p>
                    </div>
                    <div
                        class="col-span-2 border border-t-0 border-l-0 border-r-0 border-gray-300 border-solid p-4"
                    >
                        <h1 class="text-2xl font-bold">0$</h1>
                        <p>Signing up an account</p>
                    </div>
                    <div class="col-span-2"></div>
                </div>
            </div>
            <div class="p-6">
                <img :src="DatabaseImage" alt="" />
            </div>
        </div>
    </div>
</template>
