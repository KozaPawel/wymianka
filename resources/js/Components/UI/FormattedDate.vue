<template>
    {{ formattedDate }}
</template>

<script setup>
const props = defineProps({
    date: String,
})

const monthNames = [
    'stycznia', 'lutego', 'marca',
    'kwietnia', 'maja', 'czerwca',
    'lipca', 'sierpnia', 'września',
    'października', 'listopada', 'grudnia',
]

const date = new Date(props.date)

const day = date.getDate()
const monthIndex = date.getMonth()
const year = date.getFullYear()

const format = () => `${day} ${monthNames[monthIndex]} ${year}`

const formattedDate = format(date)

</script>