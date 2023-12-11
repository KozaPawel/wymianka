<template>
    <div class="grid grid-cols-12 gap-4">
        <Box class="h-fit p-4 col-span-12 md:col-span-7 w-full">
            <ImageCarousel :images="props.listing.images" />
        </Box>

        <div class="col-span-12 md:col-span-5 flex flex-col gap-4">
            <Box class="h-auto">
                <template #header>
                    Informacje: 
                </template>
                
                <ListingDetails :listing="props.listing" />
                
                <p class="break-all">{{ category.name }}</p>
            </Box>
            <MakeOffer 
                v-if="(user && user.id != props.listing.user_id) && !offer" 
                :user-listings="userListings" 
                :listing-id="props.listing.id"
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
import ImageCarousel from '@/Components/ImageCarousel.vue'

const props = defineProps({
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
