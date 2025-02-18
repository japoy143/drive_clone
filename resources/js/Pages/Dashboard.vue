<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="flex flex-col h-full p-4">
            <h1 class="text-xl font-medium">Dashboard</h1>
            <!-- Recently added -->
            <div class="mt-6">
                <div class="flex justify-between">
                    <h2>Recently added</h2>
                    <Link :href="route('myfiles')" class="underline"
                        >See More</Link
                    >
                </div>
                <!-- Recently files container -->
                <div class="grid grid-cols-3 gap-2 lg:gap-16">
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
                        <p>
                            {{ limitedLetters(file.name, file.mime, file.id) }}
                        </p>
                    </div>
                </div>
            </div>
            <!-- Favorites  -->

            <!-- Favorites expands to take the remaining space -->
            <!-- Favorites expands to take the remaining space -->
            <div
                class="flex-1 bg-white h-full p-4 rounded-md shadow-md overflow-hidden flex flex-col"
            >
                <h2 class="text-lg font-medium">Favorites</h2>

                <!-- Scrollable Table Container -->
                <div class="flex-1 overflow-auto">
                    <table
                        class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700"
                    >
                        <thead>
                            <tr>
                                <th
                                    class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500"
                                >
                                    Name
                                </th>
                                <th
                                    class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500"
                                >
                                    Path
                                </th>
                                <th
                                    class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500"
                                >
                                    Type
                                </th>
                                <th
                                    class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase dark:text-neutral-500"
                                >
                                    Created at
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="item in favorites"
                                :key="item.id"
                                class="odd:bg-white even:bg-gray-100 hover:bg-gray-100 dark:odd:bg-neutral-800 dark:even:bg-neutral-700 dark:hover:bg-neutral-700"
                            >
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-200"
                                >
                                    {{ item.name }}
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200"
                                >
                                    {{ item.path }}
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200"
                                >
                                    {{ item.mime }}
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium"
                                >
                                    {{ convertTime(item.created_at) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
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
    favorites: Object,
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

const convertTime = (time) => {
    const date = new Date(time);

    const formattedDate = date.toLocaleString(); // Default format based on user locale
    return formattedDate;
};
</script>
