<template>
    <div class="flex gap-2">
        <Link
            v-if="prevPageUrl" 
            class="py-2 px-4 rounded-lg" 
            :href="prevPageUrl"
        >
            <!-- zamienic na symbole -->
            &lt;
        </Link>
        <div v-else class="py-2 px-4 rounded-lg hover:cursor-default">
            &lt;
        </div>
        <Link
            v-for="(link, index) in links.slice(1, -1)" :key="index" 
            class="py-2 px-4 rounded-lg transition-colors duration-300 ease-in-out hover:bg-light-primary hover:text-white" 
            :href="link.url" 
            :class="{'bg-light-primary text-white': link.active}"
        >
            {{ link.label }}
        </Link>
        <Link
            v-if="nextPageUrl" 
            class="py-2 px-4 rounded-lg" 
            :href="nextPageUrl"
        >
            <!-- zamienic na symbole -->
            >
        </Link>
        <div v-else class="py-2 px-4 rounded-lg hover:cursor-default">
            >
        </div>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    links: Array,
    prevPageUrl: String,
    nextPageUrl: String,
})
</script>