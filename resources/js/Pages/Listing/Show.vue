<template>
    <div class="grid grid-cols-12 gap-4">
        <Box class="col-span-12 md:col-span-7 w-full">
            <Carousel v-if="numberOfImages">
                <Slide v-for="image in props.listing.images" :key="image.id" class="h-96 w-fit hover:cursor-pointer">
                    <div>
                        <img :src="image.source" class="h-96 w-fit" />
                    </div>
                </Slide>
                
                <template #addons>
                    <Navigation 
                        v-if="numberOfImages > 1"
                        class="!carousel-arrow"
                    />
                    <Pagination v-if="numberOfImages > 1" />
                </template>
            </Carousel>

            <div v-else class="w-full text-center font-medium">
                Brak zdjęć
            </div>
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
import { Carousel, Navigation, Pagination, Slide } from 'vue3-carousel'
import 'vue3-carousel/dist/carousel.css'
import ListingDetails from '@/Components/ListingDetails.vue'
import Box from '@/Components/UI/Box.vue'
import MakeOffer from '@/Components/MakeOffer.vue'
import Offer from '@/Components/Offer.vue'

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

const numberOfImages = props.listing.images.length

</script>
