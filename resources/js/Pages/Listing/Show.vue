<template>
    <div class="grid grid-cols-12 gap-4">
        <Box class="col-span-12 md:col-span-7 flex items-center w-full">
            <div v-if="listing.images.length" class="grid grid-cols-2 gap-1">
                <img
                    v-for="image in listing.images" :key="image.id"
                    :src="image.source"
                />
            </div>
            <div v-else class="w-full text-center font-medium">
                Brak zdjęć
            </div>
        </Box>
        <div class="col-span-12 md:col-span-5 flex flex-col gap-4">
            <Box class="h-full">
                <template #header>
                    Informacje: 
                </template>
                
                <ListingDetails :listing="listing" />
                
                {{ category.name }}
            </Box>
            <MakeOffer 
                v-if="(user && user.id != listing.user_id) && !offer" 
                :user-listings="userListings" 
                :listing-id="listing.id"
            />
            <!-- <Offer
                v-if="offer" 
                :offer="offer" 
            /> -->
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import ListingDetails from '@/Components/ListingDetails.vue'
import Box from '@/Components/UI/Box.vue'
import MakeOffer from '@/Components/MakeOffer.vue'
import Offer from '@/Components/Offer.vue'

defineProps({
    listing: Object,
    category: Object,
    userListings: Object,
    offer: Object,
})

const page = usePage()

const user = computed(
    () => page.props.user,
)
</script>