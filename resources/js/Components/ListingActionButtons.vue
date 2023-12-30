<template>
    <div class="w-full md:w-52">
        <div v-if="!props.listing.timestamps.deleted_at && !props.listing.timestamps.trade_started_at">
            <Link 
                :href="route('user.listing.image.create', {listing: props.listing.id})" 
                class="block w-full btn-accent text-center"
            >
                Zdjęcia ({{ props.listing.images_count }})
            </Link>

            <Link 
                :href="route('user.listing.show', {listing: props.listing.id})" 
                class="block mt-2 w-full btn-accent text-center"
            >
                Oferty wymiany ({{ props.listing.offers_count }})
            </Link>
        </div>

        <div v-if="!props.listing.timestamps.traded_at" class="">
            <div
                v-if="!props.listing.timestamps.deleted_at && !props.listing.timestamps.trade_started_at" 
                class="flex flex-row justify-between items-center gap-1 mt-2"
            >
                <Link 
                
                    class="btn-accent w-full text-center" 
                    :href="route('listing.show', {listing: props.listing.id})"
                >
                    Wyświetl
                </Link>
                <Link 
                    class="btn-accent w-full text-center" 
                    :href="route('user.listing.edit', {listing: props.listing.id})"
                >
                    Edytuj
                </Link>

                <button 
                    class="btn-danger w-full" 
                    @click.once="deleteListing()"
                >
                    Usuń
                </button>
            </div>

            <div v-else-if="props.listing.timestamps.trade_started_at" class="flex flex-col gap-2 w-full">
                <Link
                    v-if="props.listing.can_mark_as_finished"
                    class="btn-accept w-full" 
                    :href="route('user.trade.end', {offer: props.listing.trade_id})"
                    as="button" method="put"
                >
                    Oznacz jako zakończoną
                </Link>
                <Link 
                            
                    class="btn-danger w-full" 
                    :href="route('user.trade.cancel', {offer: props.listing.trade_id})"
                    as="button" method="put"
                >
                    Anuluj wymianę
                </Link>
            </div>
        </div>

        <Link
            v-if="props.listing.timestamps.deleted_at"
            class="btn-accent w-full"
            :href="route('user.listing.restore', {listing: props.listing.id})"
            as="button" method="put"
        >
            Przywróć
        </Link>

        <div v-if="props.listing.timestamps.traded_at && !props.listing.userReviewed">
            <AddUserReview :listing="props.listing" />
        </div>
    </div>
</template>

<script setup>
import { Link, router } from '@inertiajs/vue3'
import AddUserReview from '@/Components/AddUserReview.vue'

const props = defineProps({
    listing: Object,
})

const deleteListing = () => {
    router.delete(route('user.listing.destroy', {listing: props.listing.id}))
}

</script>