<template>
    <ListingsFilter :categories="categories" :filters="filters" />
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        <Box v-for="listing in listings.data" :key="listing.id" class="hover:shadow-md">
            <div>
                <Link :href="route('listing.show', {listing: listing.id})">
                    <ListingDetails :listing="listing" class="text-md" />
                </Link>
                Kategoria: {{ listing.category.name }}
            </div>
        </Box>
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