<template>
    <div>
        <p class="text-sm text-gray-600 break-words">
            <TownInfo :town="props.listing.town" />
        </p>

        <p class="text-sm text-gray-600 break-words">
            Zamieszczono 
            <FormattedDate :date="props.listing.timestamps.created_at" />
        </p>
        
        <p class="text-md ">
            Przez {{ props.listing.user.name }}
        </p>
    </div>

    <p class="font-semibold text-3xl mt-2">
        {{ props.listing.name }}
    </p>

    <div class="mt-4">
        <p class="text-2xl font-medium">Opis</p>
        <p class="mt-1 break-words">
            {{ props.listing.description }}
        </p>
    </div>
</template>

<script setup>
import FormattedDate from '@/Components/UI/FormattedDate.vue'
import TownInfo from '@/Components/UI/TownInfo.vue'

const props = defineProps({
    listing: Object,
})
</script>