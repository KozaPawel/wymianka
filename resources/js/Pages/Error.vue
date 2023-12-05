<template>
    <div class="h-screen w-screen flex flex-col items-center justify-center">
        <p class="text-8xl font-bold text-center break-all">{{ code }}</p>
        <p class="text-2xl font-semibold text-center">{{ title }}</p>
        <p class="mt-2 text-md text-center">{{ description }}</p>
        <Link class="btn-primary mt-6" :href="route('listing.index')">
            Powrót do strony głównej
        </Link>
    </div>
</template>

<script>
export default {
    layout: null,
}
</script>


<script setup>
import { computed } from 'vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({ status: Number })

const code = computed(() => {
    return {
        503: '503',
        500: '500',
        404: '404',
        403: '403',
    }[props.status]
})

const title = computed(() => {
    return {
        503: 'Serwis niedostępny',
        500: 'Błąd serwera',
        404: 'Nie znaleziono strony',
        403: 'Zabronione',
    }[props.status]
})

const description = computed(() => {
    return {
        503: 'Przepraszamy, przeprowadzamy prace konserwacyjne. Prosimy o ponowne sprawdzenie wkrótce.',
        500: 'Ups, coś poszło nie tak na naszych serwerach.',
        404: 'Przepraszamy, nie można znaleźć szukanej strony.',
        403: 'Przepraszamy, dostęp do tej strony jest zabroniony.',
    }[props.status]
})
</script>
