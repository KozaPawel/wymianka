<template>
    <h1 class="text-3xl mb-4 font-medium">Twoje ogłoszenia</h1>
    <section class="mb-4">
        <UserListingsFilter :filters="filters" />
    </section>
    <section class="grid grid-cols-1 lg:grid-cols-2 gap-2">
        <Box v-for="listing in listings.data" :key="listing.id" :class="{'border-dashed': listing.deleted_at}">
            <div class="flex flex-col md:flex-row gap-2 md:items-center justify-between">
                <div :class="{'opacity-50': listing.deleted_at}">
                    <div 
                        v-if="listing.traded_at" 
                        class="text-xs font-bold uppercase mb-2 text-green-900 bg-green-300 p-1 rounded-md w-fit"
                    >
                        Wymieniono
                    </div>
                    <div class="xl:flex items-center gap-2">
                        <ListingDetails :listing="listing" />
                    </div>
                </div>
                <section>
                    <div class="flex items-center gap-1">
                        <Link 
                            v-if="!listing.deleted_at" 
                            class="btn-accent" 
                            :href="route('listing.show', {listing: listing.id})"
                        >
                            Wyświetl
                        </Link>
                        <Link 
                            v-if="!listing.deleted_at" 
                            class="btn-accent" 
                            :href="route('user.listing.edit', {listing: listing.id})"
                        >
                            Edytuj
                        </Link>

                        <button 
                            v-if="!listing.deleted_at" 
                            class="btn-danger" 
                            @click.once="deleteListing(listing)"
                        >
                            Usuń
                        </button>

                        <Link
                            v-else 
                            class="btn-accent"
                            :href="route('user.listing.restore', {listing: listing.id})"
                            as="button" method="put"
                        >
                            Przywróć
                        </Link>
                    </div>

                    <div class="mt-2">
                        <Link 
                            v-if="!listing.deleted_at"
                            :href="route('user.listing.image.create', {listing: listing.id})" 
                            class="block w-full btn-accent text-center"
                        >
                            Zdjęcia ({{ listing.images_count }})
                        </Link>
                    </div>
                    <div class="mt-2">
                        <Link 
                            v-if="!listing.deleted_at"
                            :href="route('user.listing.show', {listing: listing.id})" 
                            class="block w-full btn-accent text-center"
                        >
                            Oferty wymiany ({{ listing.offers_count }})
                        </Link>
                    </div>
                </section>
            </div>
        </Box>

        <div v-if="!listings.data.length" class="text-medium text-xl"> 
            Brak ogłoszeń do wyświetlenia
        </div>
    </section>

    <section v-if="listings.data.length != 0" class="w-full flex justify-center my-6">
        <Pagination :links="listings.meta.links" :prev-page-url="listings.links.prev" :next-page-url="listings.links.next" />
    </section>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3'
import Box from '@/Components/UI/Box.vue'
import ListingDetails from '@/Components/ListingDetails.vue'
import UserListingsFilter from '@/Components/UserListingsFilter.vue'
import Pagination from '@/Components/UI/Pagination.vue'

defineProps({
    listings: Object,
    filters: Object,
})

const deleteListing = (listing) => {
    router.delete(route('user.listing.destroy', {listing: listing.id}))
}
</script>