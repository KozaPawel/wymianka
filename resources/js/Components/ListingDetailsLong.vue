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
    <a :href="mapLink" target="_blank">
        <div class="flex flex-row justify-center items-center text-lg font-medium mt-10">
            <MapPinIcon class="text-light-danger h-10 w-12" />
            Zobacz na mapie
        </div>
    </a>
</template>

<script setup>
import FormattedDate from '@/Components/UI/FormattedDate.vue'
import TownInfo from '@/Components/UI/TownInfo.vue'
import { MapPinIcon } from '@heroicons/vue/20/solid'

const props = defineProps({
    listing: Object,
})

const mapLink = `https://www.google.com/maps/place/${props.listing.town.lat},${props.listing.town.lon}`
</script>