<template>
    <div class="grid grid-cols-12 gap-2">
        <AdminNavigation class="col-span-12 lg:col-span-2" />

        <Box class="col-span-12 lg:col-span-10">
            <h1 class="page-title">Ogłoszenia</h1>
            <div class="w-full overflow-x-scroll -m-2 mt-4">
                <table class="bg-light-background-200 w-full table-auto border-collapse">
                    <thead>
                        <tr>
                            <th class="bg-light-background-200 sticky left-0 h-fit text-black">Nazwa</th>
                            <th>Użytkownik</th>
                            <th>Kategoria</th>
                            <th>Miejscowość</th>
                            <th>Opis</th>
                            <th>Status</th>
                            <th />
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="listing in props.listings.data" :key="listing.id">
                            <td class="px-2 py-3">
                                {{ listing.name }}
                            </td>
                            <td class="px-2 py-3">
                                {{ listing.user.name }}
                            </td>
                            <td class="px-2 py-3">
                                {{ listing.category.name }}
                            </td>
                            <td class="px-2 py-3">
                                <p>{{ listing.town.name }},</p>
                                <p>{{ listing.town.county ? 'powiat ' + listing.town.county + ',': '' }}</p>
                                <p>województwo {{ listing.town.province }}</p>
                            </td>
                            <td class="px-2 py-3">
                                {{ shortDescription(listing.description) }}...
                            </td>
                            <td class="px-2 py-3">
                                <div class="flex justify-center">
                                    <ListingLabel :listing="listing" />
                                </div>
                            </td>
                            <td class="px-2 py-3 w-24">
                                <div
                                    
                                    class="flex flex-col justify-between items-center gap-1 mt-2"
                                >
                                    <Link 
                
                                        class="btn-accent w-full text-center" 
                                        :href="route('listing.show', {listing: listing.id})"
                                    >
                                        Wyświetl
                                    </Link>

                                    <button 
                                        class="btn-danger w-full" 
                                        @click.once="deleteListing(listing.id)"
                                    >
                                        Usuń
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="flex justify-center w-full mt-5">
                <Pagination :links="props.listings.meta.links" :prev-page-url="props.listings.links.prev" :next-page-url="props.listings.links.next" />
            </div>
        </Box>
    </div>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3'
import ListingLabel from '@/Components/ListingLabel.vue'
import Box from '@/Components/UI/Box.vue'
import Pagination from '@/Components/UI/Pagination.vue'
import AdminNavigation from '@/Components/AdminNavigation.vue'

const props = defineProps({
    listings: Object,
})

const shortDescription = (value) => {
    return value.slice(0,50)
}

const deleteListing = (listingId) => {
    router.delete(route('user.listing.destroy', {listing: listingId}))
}
</script>