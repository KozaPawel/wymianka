<template>
    <BackButton />

    <h1 class="page-title mb-4">Ofery wymiany</h1>
    <section class="flex flex-col-reverse md:grid md:grid-cols-12 gap-4">
        <div class="flex flex-col items-start md:col-span-7 gap-2">
            <Box v-if="!hasOffers" class="w-full text-center font-medium text-gray-500">
                Brak ofert
            </Box>

            <div v-else class="flex flex-col gap-4 w-full">
                <Offer 
                    v-for="offer in props.listing.offers" 
                    :key="offer.id" 
                    :offer="offer" 
                    :is-offer-chosen="props.listing.data.traded_at != null"
                />
            </div>
        </div>
        
        <div class="md:col-span-5 items-center">
            <Box>
                <template #header>Informacje o przedmiocie</template>
                <ListingDetails :listing="listing.data" />
            </Box>
        </div>
    </section>
</template>

<script setup>
import { computed } from 'vue'
import Box from '@/Components/UI/Box.vue'
import ListingDetails from '@/Components/ListingDetails.vue'
import Offer from '@/Components/Offer.vue'
import BackButton from '@/Components/BackButton.vue'
const props = defineProps({
    listing: Object,
})

const hasOffers = computed(
    () => props.listing.offers.length,
)
</script>