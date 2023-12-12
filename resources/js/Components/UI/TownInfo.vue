<template>
    {{ town.name }},
    {{ town.county ? town.county + ',' : '' }}
    {{ town.province }}
</template>

<script setup>
defineProps({
    town: Object,
})
</script>