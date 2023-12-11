<template>
    <div>
        <p class="text-sm text-gray-600">
            {{ props.listing.town.name }},
            {{ props.listing.town.county ? props.listing.town.county + ',' : '' }}
            {{ props.listing.town.province }}
        </p>
        <p class="text-sm text-gray-600 break-words">
            Zamieszczono {{ formattedDate }}
        </p>
        <p class="text-md ">
            Przez {{ props.listing.user.name }}
        </p>

        <p class="font-medium text-xl mt-2">
            {{ props.listing.name }}
        </p>
    </div>

    <div class="mt-4">
        <p class="text-2xl font-medium">Opis</p>
        <p class="mt-1 break-words">
            {{ props.listing.description }}
        </p>
    </div>
</template>

<script setup>
const props = defineProps({
    listing: Object,
})

const monthNames = [
    'stycznia', 'lutego', 'marca',
    'kwietnia', 'maja', 'czerwca',
    'lipca', 'sierpnia', 'września',
    'października', 'listopada', 'grudnia',
]

const date = new Date(props.listing.timestamps.created_at)

const day = date.getDate()
const monthIndex = date.getMonth()
const year = date.getFullYear()

const format = () => `${day} ${monthNames[monthIndex]} ${year}`

const formattedDate = format(date)

</script>