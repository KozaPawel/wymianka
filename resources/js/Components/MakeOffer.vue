<template>
    <Box>
        <template #header>Przedmioty które możesz wymienić</template>

        <form @submit.prevent="makeOffer">
            <div v-for="listing in userListings" :key="listing.id" class="flex items-center gap-2">
                <input :id="listing.id" :key="listing.id" v-model="form.offerId" type="radio" :value="listing.id" />
                <label :key="listing.id" :for="listing.id">{{ listing.name }}</label>
            </div>

            <button type="submit" class="btn-outline w-full mt-2 text-sm">Złóż ofertę</button>
            <ErrorMessage class="mt-2" :error="form.errors.offerId" />
        </form>
    </Box>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import Box from '@/Components/UI/Box.vue'
import ErrorMessage from './ErrorMessage.vue'

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