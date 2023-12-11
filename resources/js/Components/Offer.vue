<template>
    <Box>
        <template #header>
            Oferta #{{ offer.id }}
            <span 
                v-if="offer.accepted_at" 
                class="text-green-900 bg-green-200 rounded-md p-1"
            >
                Zaakceptowana
            </span>
        </template>
        <section class="flex items-center justify-between">
            <div>
                <p>{{ offerDate }}</p>
                <p>{{ offer }}</p>
                <p>Złożone przez {{ offer.trader.name }}</p>
            </div>
            <div>
                <Link
                    v-if="!isOfferChosen"
                    :href="route('user.offer.accept', { offer: offer.id })" 
                    class="btn-accent" 
                    method="put"
                    as="button"
                >
                    Zaakceptuj
                </Link>
            </div>
        </section>
    </Box>
</template>

<script setup>
import { computed } from 'vue'
import { Link } from '@inertiajs/vue3'
import Box from '@/Components/UI/Box.vue'

const props = defineProps({
    offer: Object,
    isOfferChosen: Boolean,
})

const offerDate = computed(
    () => new Date(props.offer.created_at).toDateString(),
)
</script>