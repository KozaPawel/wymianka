<template>
    <BackButton />

    <h1 class="page-title mb-4">Oferty wymiany</h1>
    <section class="flex flex-col-reverse md:grid md:grid-cols-12 gap-4">
        <div class="flex flex-col items-start md:col-span-7 gap-2">
            <Box v-if="!hasOffers" class="w-full text-center font-medium ">
                <div class="flex flex-col items-center justify-center">
                    <ArrowsRightLeftIcon class="h-10 w-10" />
                    <span class="text-xl font-bold">Brak ofert</span>
                </div>
            </Box>

            <div v-else class="flex flex-col gap-4 w-full">
                <Offer 
                    v-for="offer in props.listing.offers" 
                    :key="offer.id" 
                    :offer="offer" 
                    :is-offer-chosen="offer.accepted_at != null || offer.rejected_at != null"
                />
            </div>
        </div>
        
        <div class="md:col-span-5 items-center">
            <Box>
                <ListingDetailsShort :listing="listing.data" class="!p-0" />
            </Box>
        </div>
    </section>
</template>

<script setup>
import { computed } from 'vue'
import { ArrowsRightLeftIcon } from '@heroicons/vue/20/solid'
import Box from '@/Components/UI/Box.vue'
import ListingDetailsShort from '@/Components/ListingDetailsShort.vue'
import Offer from '@/Components/Offer.vue'
import BackButton from '@/Components/BackButton.vue'

const props = defineProps({
    listing: Object,
})

const hasOffers = computed(
    () => props.listing.offers.length,
)
</script>