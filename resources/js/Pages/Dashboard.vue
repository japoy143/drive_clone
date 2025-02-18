<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="flex justify-between mb-6">
            <h1 class="text-xl font-medium">Dashboard</h1>
        </div>
        <!-- Recently added -->
        <div>
            <div class="flex justify-between">
                <h2>Recently added</h2>
                <Link :href="route('myfiles')" class="underline">See More</Link>
            </div>
            <!-- Recently files container -->
            <div class="grid grid-cols-3 gap-2">
                <div
                    v-for="file in files"
                    :key="file.id"
                    class="col-span-1 p-2"
                >
                    <div
                        class="bg-slate-50 h-[140px] rounded-md flex flex-col items-center justify-center"
                    >
                        <PhotoIcon
                            v-if="hasImage(file.mime)"
                            class="size-28 text-gray-500"
                        />
                        <DocumentTextIcon
                            v-else
                            class="size-28 text-gray-500"
                        />
                    </div>
                    <p>{{ limitedLetters(file.name, file.mime, file.id) }}</p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { DocumentTextIcon, PhotoIcon } from "@heroicons/vue/24/outline";
import { Head, Link } from "@inertiajs/vue3";

defineProps({
    files: Object,
});

//extension type
const images = ["png", "jpg", "jpeg", "svg", "gif", "webp"];

const hasImage = (image) => {
    return images
        .map((item) => item.toLowerCase())
        .includes(image.toLowerCase());
};

const limitedLetters = (words, extension, id) => {
    const letterCount = 15;
    const splittedWords = words.split("");
    let joinWord = "";
    if (splittedWords.length >= 15) {
        for (let i = 0; i < letterCount; i++) {
            joinWord += splittedWords[i];
        }

        joinWord += id;
        joinWord += ".";
        joinWord += extension;

        return joinWord;
    } else {
        joinWord += words;
        joinWord += ".";
        joinWord += extension;

        return joinWord;
    }
};
</script>
