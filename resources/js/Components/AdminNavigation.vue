<template>
    <Box class="flex flex-col h-fit gap-2">
        <Link :href="route('admin.listings')" class="btn-accent w-full text-left">
            Ogłoszenia
        </Link>
        <Link :href="route('admin.reviews')" class="btn-accent w-full text-left">
            Opinie
        </Link>
        <Link :href="route('admin.categories')" class="btn-accent w-full text-left">
            Kategorie
        </Link>
        <Link :href="route('admin.towns')" class="btn-accent w-full text-left">
            Miejscowości
        </Link>
    </Box>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import Box from './UI/Box.vue'
</script>