<template>
    <div>
        <p>Name:  {{ listing.name }}</p>
        <p>City: {{ listing.city }}</p>
        <p>Descr: {{ listing.description }}</p>
    </div>
</template>

<script setup>
defineProps({
    listing: Object,
})
</script>