<template>
    <Box>
        <div class="mb-4">
            <h1 class="font-bold text-2xl break-words w-full">{{ props.user.name }}</h1>
            <p class="text-gray-600 text-sm">
                Dołączono <FormattedDate :date="props.user.created_at" />
            </p>
        </div>
        <div class="flex flex-row w-full gap-4">
            <div class="w-full md:w-fit bg-light-accent rounded-md  shadow-gray-200 p-3">
                <p class="font-medium text-center">Ilość wymian: {{ props.numberOfTrades }}</p>
            </div>
            <div class="w-full md:w-fit bg-light-accent rounded-md  shadow-gray-200 p-3">
                <p class="font-medium text-center">
                    {{ reviews.length === 0 ? "Brak ocen" : "Ocena: " + ratingAverage }}
                </p>
            </div>
        </div>
        
        <hr class="h-px my-8 bg-gray-200" />

        <div class="flex gap-2 mt-6">
            <button
                class="btn-accent" 
                :class="{'border-b-light-primary border-b-2': content === 'listings'}" 
                @click="changeContent('listings')"
            >
                Ogłoszenia
            </button>
            <button
                class="btn-accent" 
                :class="{'border-b-light-primary border-b-2': content === 'reviews'}" 
                @click="changeContent('reviews')"
            >
                Opinie ({{ reviews.length }})
            </button>
        </div>
    </Box>
    
    <section v-if="content === 'listings'" class="mt-4">
        <div v-if="listings.length === 0" class="flex flex-col items-center justify-center">
            <ListBulletIcon class="h-10 w-10" />
            <span class="text-xl font-bold">Brak ogłoszeń do wyświetlenia</span>
        </div>

        <div v-else class="grid grid-cols-12 gap-2">
            <Box v-for="listing in listings" :key="listing.id" class="col-span-6 md:col-span-4 xl:col-span-2 p-0">
                <Link :href="route('listing.show', { listing: listing})">
                    <CoverPhoto :images="listing.images" class="h-48 w-full" />
                    <ListingDetailsShort :listing="listing" />
                </Link>
            </Box>
        </div>
    </section>

    <section v-if="content === 'reviews'" class="mt-4">
        <div v-if="reviews.length === 0" class="flex flex-col items-center justify-center">
            <ClipboardDocumentListIcon class="h-10 w-10" />
            <span class="text-xl font-bold">Brak opnii do wyświetlenia</span>
        </div>

        <div v-else class="grid grid-cols-12 gap-2">
            <div v-for="review in reviews" :key="review.id" class="col-span-12 md:col-span-6 xl:col-span-4 h-full">
                <Review :review="review" />
            </div>
        </div>
    </section>
</template>

<script setup>
import { computed, ref } from 'vue'
import { Link } from '@inertiajs/vue3'
import { ListBulletIcon, ClipboardDocumentListIcon } from '@heroicons/vue/20/solid'
import Box from '@/Components/UI/Box.vue'
import FormattedDate from '@/Components/UI/FormattedDate.vue'
import ListingDetailsShort from '@/Components/ListingDetailsShort.vue'
import Review from '@/Components/Review.vue'
import CoverPhoto from '@/Components/CoverPhoto.vue'

const props = defineProps({
    user: Object,
    listings: Object,
    reviews: Object,
    numberOfTrades: Number,
})

const content = ref('listings')

const changeContent = (display) => {
    if(display === 'listings') {
        content.value = 'listings'
    } else {
        content.value = 'reviews'
    }
}

const ratingAverage = computed(
    () => {
        var average = 0

        props.reviews.forEach(element => {
            average += element.rating
        })

        if(!average) {
            return
        }

        return (average / props.reviews.length).toFixed(2)
    },
)
</script>