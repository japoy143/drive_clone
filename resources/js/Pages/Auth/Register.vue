<script setup>
import GuestLayout from "@/Layouts/GuestLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
});

const submit = () => {
    form.post(route("register"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Register" />

        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2
                class="mt-6 text-center text-3xl leading-9 font-extrabold text-gray-900"
            >
                Create a new account
            </h2>
            <p class="mt-2 text-center text-sm leading-5 text-gray-500 max-w">
                Or
                <Link
                    :href="route('login')"
                    class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-black hover:bg-black/75 focus:outline-none focus:bg-black/75 focus:shadow-outline-indigo active:bg-black/75 transition duration-150 ease-in-out"
                >
                    Login to your account?
                </Link>
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
                <form @submit.prevent="submit">
                    <div>
                        <label
                            for="email"
                            class="block text-sm font-medium leading-5 text-gray-700"
                            >Name</label
                        >
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input
                                id="name"
                                type="text"
                                placeholder="John Doe"
                                v-model="form.name"
                                required
                                autofocus
                                autocomplete="name"
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                            />
                            <InputError
                                class="mt-2"
                                :message="form.errors.name"
                            />
                            <div
                                class="hidden absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none"
                            >
                                <svg
                                    class="h-5 w-5 text-red-500"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd"
                                    ></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <label
                            for="email"
                            class="block text-sm font-medium leading-5 text-gray-700"
                        >
                            Email address
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input
                                id="email"
                                type="email"
                                v-model="form.email"
                                placeholder="JohnDoe@email.com"
                                required
                                autocomplete="username"
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                            />
                            <InputError
                                class="mt-2"
                                :message="form.errors.email"
                            />
                            <div
                                class="hidden absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none"
                            >
                                <svg
                                    class="h-5 w-5 text-red-500"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd"
                                    ></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <label
                            for="password"
                            class="block text-sm font-medium leading-5 text-gray-700"
                        >
                            Password
                        </label>
                        <div class="mt-1 rounded-md shadow-sm">
                            <input
                                id="password"
                                type="password"
                                v-model="form.password"
                                placeholder="********"
                                required
                                autocomplete="new-password"
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                            />
                            <InputError
                                class="mt-2"
                                :message="form.errors.password"
                            />
                        </div>
                    </div>

                    <div class="mt-6">
                        <label
                            for="password_confirmation"
                            class="block text-sm font-medium leading-5 text-gray-700"
                        >
                            Confirm Password
                        </label>
                        <div class="mt-1 rounded-md shadow-sm">
                            <input
                                id="password_confirmation"
                                type="password"
                                placeholder="********"
                                v-model="form.password_confirmation"
                                required
                                autocomplete="new-password"
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md placeholder-gray-400 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5"
                            />
                            <InputError
                                class="mt-2"
                                :message="form.errors.password_confirmation"
                            />
                        </div>
                    </div>

                    <div class="mt-6">
                        <span class="block w-full rounded-md shadow-sm">
                            <button
                                type="submit"
                                class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-black hover:bg-black/75 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out"
                            >
                                Create account
                            </button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
    </GuestLayout>
</template>
