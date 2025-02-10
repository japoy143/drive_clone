<template>
    <Menu as="div" class="relative block text-left">
        <div>
            <MenuButton
                class="inline-flex w-full justify-center rounded-md bg-black px-4 py-2 text-sm font-medium text-white hover:bg-black/30 focus:outline-none focus-visible:ring-2 focus-visible:ring-white/75"
            >
                {{ dropDownName }}
            </MenuButton>
        </div>

        <transition
            enter-active-class="transition duration-100 ease-out"
            enter-from-class="transform scale-95 opacity-0"
            enter-to-class="transform scale-100 opacity-100"
            leave-active-class="transition duration-75 ease-in"
            leave-from-class="transform scale-100 opacity-100"
            leave-to-class="transform scale-95 opacity-0"
        >
            <MenuItems
                class="absolute left-0 mt-2 w-56 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none"
            >
                <div
                    class="px-1 py-1"
                    v-for="item in menuItems"
                    :key="item.name"
                >
                    <MenuItem v-slot="{ active }">
                        <button
                            @click="item.action"
                            :class="[
                                active
                                    ? 'bg-black text-white'
                                    : 'text-gray-900',
                                'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                            ]"
                        >
                            {{ item.name }}
                        </button>
                    </MenuItem>
                </div>
            </MenuItems>
        </transition>
    </Menu>
</template>

<script setup>
import { ChevronDownIcon } from "@heroicons/vue/20/solid";
import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue"; // ✅ Add missing imports

defineProps({
    dropDownName: {
        type: String,
        required: true,
    },
    menuItems: {
        type: Array,
        required: true,
    },
});
</script>
