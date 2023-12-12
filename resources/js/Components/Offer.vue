<template>
    <Box :class="{'bg-red-50': offer.rejected_at,}">
        <template #header>
            <div class="flex flex-row items-center">
                Oferta #{{ offer.id }}
                <span 
                    v-if="offer.accepted_at" 
                    class="ml-4 text-white text-sm bg-light-primary rounded-md p-1"
                >
                    Zaakceptowana
                </span>
                <span v-if="offer.rejected_at" class="ml-4 text-white text-sm bg-light-danger rounded-md p-1">
                    Odrzucona
                </span>
            </div>
        </template>
        <section class="flex items-center justify-between" :class="{'opacity-50': offer.rejected_at}">
            <div class="flex flex-col lg:flex-row w-full h-full">
                <div class="w-full">
                    <p class="text-lg">
                        Złożona przez
                        {{ offer.trader.name }}
                    </p>
                    <p class="text-sm text-gray-600">
                        <TownInfo :town="offer.data.town" />
                    </p>
                    <p class="text-sm text-gray-600 mb-2">
                        <FormattedDate :date="offerDate" />
                    </p>
                    <Link :href="route('listing.show', {listing: offer.data.id})" class="hover:underline">
                        <p class="text-2xl font-semibold mb-2">{{ offer.data.name }}</p>

                        <div class="flex justify-center">
                            <img v-if="offer.data.images.length" :src="offer.data.images[0].source" class="aspect-square h-80 w-fit object-cover rounded-md" />
                            <NoPhotos v-else class="aspect-square" />
                        </div>
                    </Link>
                </div>
                <div class="flex flex-row lg:flex-col justify-between lg:justify-start mt-4 lg:mt-0 gap-4 lg:gap-2">
                    <Link
                        v-if="!isOfferChosen && !offer.rejected_at"
                        :href="route('user.offer.accept', { offer: offer.id })" 
                        class="btn-accept w-full lg:w-28" 
                        method="put"
                        as="button"
                    >
                        Zaakceptuj
                    </Link>
                    <Link
                        v-if="!isOfferChosen && !offer.rejected_at"
                        :href="route('user.offer.reject', { offer: offer.id })" 
                        class="btn-reject w-full lg:w-28" 
                        method="put"
                        as="button"
                    >
                        Odrzuć
                    </Link>
                </div>
            </div>
        </section>
    </Box>
</template>

<script setup>
import { computed } from 'vue'
import { Link } from '@inertiajs/vue3'
import Box from '@/Components/UI/Box.vue'
import FormattedDate from '@/Components/UI/FormattedDate.vue'
import NoPhotos from '@/Components/NoPhotos.vue'
import TownInfo from '@/Components/UI/TownInfo.vue'

const props = defineProps({
    offer: Object,
    isOfferChosen: Boolean,
})

const offerDate = computed(
    () => new Date(props.offer.created_at).toDateString(),
)
</script>