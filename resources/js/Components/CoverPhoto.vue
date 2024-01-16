<template>
    <div>
        <img
            v-if="props.images.length" 
            :src="props.images[0].source" 
            class="aspect-square h-full w-full object-cover rounded-t-md" 
            :class="{'rounded-md': page.url.slice(0,13) === '/user/listing'}"
        />
        <NoPhotos v-else class="aspect-square h-full w-full" />
    </div>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3'
import NoPhotos from './NoPhotos.vue'

const page = usePage()

const props = defineProps({
    images: Object,
})
</script>