<template>
    <div class="grid grid-cols-12 gap-2">
        <!-- <div>
            Szukanie dla: {{ filters.search }}
        </div> -->
        <ListingsFilter :categories="categories" :filters="filters" class="col-span-12 xl:col-span-2" />

        <div class="col-span-12 lg:col-span-10">
            <div v-if="listings.data.length" class="grid grid-cols-2 xl:grid-cols-3 gap-4">
                <Box v-for="listing in listings.data" :key="listing.id">
                    <div>
                        <Link :href="route('listing.show', {listing: listing.id})">
                            <ListingDetails :listing="listing" class="text-md" />
                        </Link>
                        <p class="break-all">
                            Kategoria: {{ listing.category.name }}
                        </p>
                    </div>
                </Box>
            </div>
            <div v-else class="flex justify-center">
                <p class="text-3xl font-bold">Brak ogłoszeń</p>
            </div>
        </div>
    </div>
    <div v-if="listings.data.length" class="w-full flex justify-center mt-4 mb-4">
        <Pagination :links="listings.links" :prev-page-url="listings.prev_page_url" :next-page-url="listings.next_page_url" />
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import ListingDetails from '@/Components/ListingDetails.vue'
import Box from '@/Components/UI/Box.vue'
import Pagination from '@/Components/UI/Pagination.vue'
import ListingsFilter from '@/Components/ListingsFilter.vue'

defineProps({
    listings: Object,
    categories: Object,
    filters: Object,
})
</script>