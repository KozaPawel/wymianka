<template>
    <div class="pl-4 p-3">
        <p class="font-medium text-xl mb-2">{{ listing.name }}</p>
        <p class="text-sm text-gray-600 break-words">
            {{ listing.town.name }},
            {{ listing.town.county ? listing.town.county + ',' : '' }}
            {{ listing.town.province }}
        </p>
    </div>
</template>

<script setup>
defineProps({
    listing: Object,
})
</script>