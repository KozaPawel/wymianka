<template>
    <div class="flex gap-2">
        <Link
            class="py-2 px-4 rounded-lg" 
            :href="prevPageUrl ?? ''"
            :class="{'opacity-50 pointer-events-none': !prevPageUrl}"
        >
            <ChevronLeftIcon
                class="menu-icon"
                aria-hidden="true"
            />
        </Link>
        
        <Link
            v-for="link in links.slice(1, -1)" :key="link.label" 
            class="py-2 px-4 rounded-lg transition-colors duration-300 ease-in-out hover:bg-light-primary hover:text-white" 
            :href="link.url" 
            :class="{'bg-light-primary text-white': link.active}"
        >
            {{ link.label }}
        </Link>

        <Link
            class="py-2 px-4 rounded-lg" 
            :href="nextPageUrl ?? ''"
            :class="{'opacity-50 pointer-events-none': !nextPageUrl}"
        >
            <ChevronRightIcon
                class="menu-icon"
                aria-hidden="true"
            />
        </Link>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/20/solid'

defineProps({
    links: Array,
    prevPageUrl: String,
    nextPageUrl: String,
})
</script>