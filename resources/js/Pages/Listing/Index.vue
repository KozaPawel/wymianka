<template>
    <div class="h-full w-full flex flex-col md:flex-row md:justify-between mb-2">
        <div class="page-title">
            <p>
                <Link 
                    :href="route('listing.index')" 
                    :class="{'hover:underline': (isSearching || isSearchingTown), 'pointer-events-none': !(isSearching || isSearchingTown)}"
                >
                    Wszystkie ogłoszenia
                </Link>
                <span v-if="isSearching"> > {{ page.props.filters.search }} </span>
            </p>
        </div>
        <form class="group flex flex-col gap-2 md:gap-1 md:flex-row items-center justify-end w-full md:w-1/2 lg:w-3/4 col-span-12" @submit.prevent="search">
            <div class="flex flex-row items-center justify-end w-full md:w-1/3">
                <input 
                    v-model="filterForm.search" 
                    type="text" 
                    placeholder="Wyszukaj" 
                    class="input text-md border border-transparent w-full"
                />
            </div>

            <div class="flex flex-row gap-2 md:gap-1 w-full md:w-1/2">
                <TownSearch @selected-town="filterForm.town = $event.id" />
            
                <button type="submit" class="btn-accent p-0">
                    <div class="h-9 w-9 flex items-center justify-center">
                        <MagnifyingGlassIcon class="h-6" />
                    </div>
                </button>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-12 gap-2">
        <ListingsFilter :categories="props.categories" :filters="props.filters" class="col-span-12 lg:col-span-2" />

        <div class="col-span-12 lg:col-span-10">
            <div v-if="props.listings.data.length" class="grid grid-cols-1 md:grid-cols-3 xl:grid-cols-4 gap-4">
                <Box v-for="listing in props.listings.data" :key="listing.id" class="p-0 overflow-hidden">
                    <div>
                        <Link :href="route('listing.show', {listing: listing.id})">
                            <img v-if="listing.images.length" :src="listing.images[0].source" class="aspect-square h-full w-full object-cover rounded-t-md" />
                            <NoPhotos v-else class="aspect-square" />
                            <ListingDetails :listing="listing" />
                        </Link>
                    </div>
                </Box>
            </div>
            <div v-else class="flex justify-center">
                <p class="text-3xl font-bold">Brak ogłoszeń</p>
            </div>
        </div>
    </div>
    <div v-if="props.listings.meta.last_page !== 1" class="w-full flex justify-center mt-4 mb-4">
        <Pagination :links="props.listings.meta.links" :prev-page-url="props.listings.links.prev" :next-page-url="props.listings.links.next" />
    </div>
</template>

<script setup>
import { computed, reactive } from 'vue'
import { Link, router, usePage } from '@inertiajs/vue3'
import { MagnifyingGlassIcon } from '@heroicons/vue/20/solid'
import ListingDetails from '@/Components/ListingDetails.vue'
import Box from '@/Components/UI/Box.vue'
import Pagination from '@/Components/UI/Pagination.vue'
import ListingsFilter from '@/Components/ListingsFilter.vue'
import TownSearch from '@/Components/TownSearch.vue'
import NoPhotos from '@/Components/NoPhotos.vue'

const props = defineProps({
    listings: Object,
    categories: Object,
    filters: Object,
})

const page = usePage()

const categoryList = computed(
    () => page.props.filters.categories,
)

const filterForm = reactive({
    search: props.filters.search ?? '',
    categories: categoryList,
    town: props.filters.town ?? '',
})

const isSearching = computed(
    () => page.props.filters.search != null,
)

const isSearchingTown = computed(
    () => page.props.filters.town != null,
)

const search = () => {
    router.get(
        route('listing.index'),
        filterForm,
        {
            preserveState: true,
            preserveScroll: true,
        },
    ),
    filterForm.search = ''
}
</script>