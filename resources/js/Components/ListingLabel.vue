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
</template>

<script setup>
defineProps({
    listing: Object,
})
</script>