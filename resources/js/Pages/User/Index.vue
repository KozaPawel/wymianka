<template>
    <h1 class="page-title">Twoje ogłoszenia</h1>
    <section class="mb-4">
        <UserListingsFilter :filters="filters" />
    </section>
    <section class="grid grid-cols-1 lg:grid-cols-2 gap-2">
        <Box
            v-for="listing in listings.data" :key="listing.id" 
            class="flex items-center w-full" 
            :class="{'border-dashed': listing.timestamps.deleted_at}"
        >
            <div class="flex flex-col md:flex-row gap-2 md:items-center justify-between w-full">
                <div :class="{'opacity-50': listing.timestamps.deleted_at}">
                    <ListingLabel :listing="listing" />

                    <div class="flex flex-col justify-start gap-2 w-fit">
                        <ListingDetailsShort :listing="listing" class="!pl-0 !pt-0 md:!pl-4 md:!pt-3" />

                        <p v-if="listing.trade_for" class="pl-0 md:pl-4 md:!pt-2 text-sm">
                            Za przedmiot użytkownika {{ listing.trade_for.user.name }}
                        </p>
                        <ListingDetailsShort v-if="listing.trade_for" :listing="listing.trade_for" class="!pl-0 !pt-0 md:!pl-4" />
                    </div>
                </div>

                <ListingActionButtons :listing="listing" />
            </div>
        </Box>

        <div v-if="!listings.data.length" class="text-medium text-xl"> 
            Brak ogłoszeń do wyświetlenia
        </div>
    </section>

    <section v-if="listings.meta.last_page !== 1" class="w-full flex justify-center my-6">
        <Pagination :links="listings.meta.links" :prev-page-url="listings.links.prev" :next-page-url="listings.links.next" />
    </section>
</template>

<script setup>
import Box from '@/Components/UI/Box.vue'
import ListingDetailsShort from '@/Components/ListingDetailsShort.vue'
import UserListingsFilter from '@/Components/UserListingsFilter.vue'
import Pagination from '@/Components/UI/Pagination.vue'
import ListingActionButtons from '@/Components/ListingActionButtons.vue'
import ListingLabel from '@/Components/ListingLabel.vue'

defineProps({
    listings: Object,
    filters: Object,
})

</script>