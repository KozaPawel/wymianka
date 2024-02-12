<template>
    <div 
        v-if="listing.timestamps.traded_at" 
        class="listing-label bg-light-primary"
    >
        Wymieniono
    </div>
    <div 
        v-if="listing.timestamps.trade_started_at && !listing.timestamps.traded_at" 
        class="listing-label bg-orange-600"
    >
        Wymiana w trakcie
    </div>
    <div 
        v-if="!listing.timestamps.trade_started_at && !listing.timestamps.traded_at && page.url === '/admin/listings'" 
        class="listing-label bg-blue-500"
    >
        Wystawiony
    </div>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3'

defineProps({
    listing: Object,
})

const page = usePage()
</script>