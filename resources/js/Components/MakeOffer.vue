<template>
    <Box>
        <template #header>Twoje przedmioty</template>

        <form @submit.prevent="makeOffer">
            <div class="grid grid-cols-12 gap-2 h-80 mt-2 overflow-y-auto p-1">
                <div
                    v-for="listing in userListings" :key="listing.id" class="col-span-6 xl:col-span-4 rounded-md" 
                    :class="{'transition duration-200 ease-in outline-none border-light-focus ring-2 ring-light-focus': form.offerId === listing.id}"
                >
                    <input :id="listing.id" :key="listing.id" v-model="form.offerId" type="radio" :value="listing.id" class="hidden" />
                    <label :key="listing.id" :for="listing.id" class="hover:cursor-pointer">
                        <Box class="p-0 h-full" :class="{'shadow-sm': form.offerId === listing.id}">
                            <CoverPhoto :images="listing.images" class="h-32 w-full" />
                            <ListingDetailsShort :listing="listing" />
                        </Box>
                    </label>
                </div>
            </div>

            <button type="submit" class="btn-primary w-full mt-2 text-sm col-span-12">Złóż ofertę</button>
            <ErrorMessage class="mt-2" :error="form.errors.offerId" />
        </form>
    </Box>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import Box from '@/Components/UI/Box.vue'
import ErrorMessage from './ErrorMessage.vue'
import ListingDetailsShort from './ListingDetailsShort.vue'
import CoverPhoto from './CoverPhoto.vue'

const form = useForm({
    offerId: props.offerId,
    listingId: props.listingId,
})

const props = defineProps({
    listingId: Number,
    offerId: Number,
    userListings: Object,
})

const makeOffer = () => form.post(
    route('listing.offer.store', {listing: props.listingId}), 
    {
        preserveScroll: true,
        preserveState: true,
    })
</script>