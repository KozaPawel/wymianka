<template>
    <div class="pl-4 p-3">
        <p class="font-medium text-xl mb-2 break-all">{{ listing.name }}</p>
        <p class="text-sm text-gray-600 break-words">
            <TownInfo :town="listing.town" />
        </p>
    </div>
</template>

<script setup>
import TownInfo from '@/Components/UI/TownInfo.vue'

defineProps({
    listing: Object,
})
</script>