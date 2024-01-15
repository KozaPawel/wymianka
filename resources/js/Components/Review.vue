<template>
    <Box class="col-span-12 md:col-span-6 xl:col-span-4 h-full">
        <div class="flex items-center justify-between font-medium">
            <div class="flex flex-col">
                <Link :href="route('user.show', { user: props.review.made_by.id })" class="hover:underline w-fit">
                    {{ props.review.made_by.name }}
                </Link>
                <p class="text-gray-600 text-xs">
                    Dodano <FormattedDate :date="props.review.created_at" />
                </p>
            </div>
                    
            <div class="flex flex-row gap-1">
                <text> {{ props.review.rating }}</text>
                <StarIcon class="h-5 w-5 text-yellow-400" />
            </div>
        </div>

        <div class="mt-4">
            <text class=" break-all">{{ props.review.summary }}</text>
        </div>
    </Box>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import Box from './UI/Box.vue'
import FormattedDate from './UI/FormattedDate.vue'
import { StarIcon } from '@heroicons/vue/20/solid'

const props = defineProps({
    review: Object,
})
</script>