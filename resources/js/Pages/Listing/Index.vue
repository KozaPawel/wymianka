<template>
    <div class="h-full w-full flex flex-col md:flex-row md:justify-between mb-2">
        <div class="font-bold text-3xl mb-2 break-words w-full">
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
        <form class="flex flex-col gap-1 md:flex-row items-center justify-end w-full md:w-1/2 lg:w-3/4 col-span-12" @submit.prevent="search">
            <div class="flex flex-row items-center justify-end w-full">
                <input 
                    v-model="filterForm.search" 
                    type="text" 
                    placeholder="Wyszukaj" 
                    class="input text-sm border-none bg-white lg:w-1/3"
                />
            </div>

            <TownSearch @selected-town="filterForm.town = $event.id" />
            
            <button type="submit" class="btn-accent p-0">
                <div class="h-9 w-9 flex items-center justify-center">
                    <MagnifyingGlassIcon class="h-6" />
                </div>
            </button>
        </form>
    </div>

    <div class="grid grid-cols-12 gap-2">
        <ListingsFilter :categories="props.categories" :filters="props.filters" class="col-span-12 lg:col-span-2" />

        <div class="col-span-12 lg:col-span-10">
            <div v-if="props.listings.data.length" class="grid grid-cols-2 xl:grid-cols-3 gap-4">
                <Box v-for="listing in props.listings.data" :key="listing.id">
                    <div>
                        <Link :href="route('listing.show', {listing: listing.id})">
                            <ListingDetails :listing="listing" class="text-md" />
                        </Link>
                        <p class="break-all">
                            Kategoria: {{ listing.category_name }}
                            <br />
                            Miasto: {{ listing.town_name }}
                        </p>
                    </div>
                </Box>
            </div>
            <div v-else class="flex justify-center">
                <p class="text-3xl font-bold">Brak ogłoszeń</p>
            </div>
        </div>
    </div>
    <div v-if="props.listings.data.length" class="w-full flex justify-center mt-4 mb-4">
        <Pagination :links="props.listings.meta.links" :prev-page-url="props.listings.links.prev" :next-page-url="props.listings.links.next" />
    </div>
</template>

<script setup>
import { computed, reactive } from 'vue'
import { Link, router, usePage } from '@inertiajs/vue3'
import ListingDetails from '@/Components/ListingDetails.vue'
import Box from '@/Components/UI/Box.vue'
import Pagination from '@/Components/UI/Pagination.vue'
import ListingsFilter from '@/Components/ListingsFilter.vue'
import TownSearch from '@/Components/TownSearch.vue'
import { MagnifyingGlassIcon } from '@heroicons/vue/20/solid'

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