<template>
    <Link :href="route('user.listing.index', { status: 'all'})" class="flex flex-row items-center gap-1 mb-4 text-accent !p-1 !pr-2 w-fit">
        <ArrowSmallLeftIcon class="h-8 w-8" />
        <span class="font-medium text-md">Profil</span>
    </Link>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { ArrowSmallLeftIcon } from '@heroicons/vue/20/solid'
</script>