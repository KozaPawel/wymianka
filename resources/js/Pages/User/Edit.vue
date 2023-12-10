<template>
    <BackButton />

    <form @submit.prevent="update">
        <div class="grid grid-cols-6 gap-4">
            <div class="col-span-6">
                <label class="label">Name</label>
                <input v-model="form.name" type="text" class="input" />
                <ErrorMessage :error="form.errors.name" />
            </div>

            <div class="col-span-6">
                <label class="label">Description</label>
                <input v-model="form.description" type="text" class="input" />
                <ErrorMessage :error="form.errors.description" />
            </div>

            <div class="col-span-6">
                <label class="label">Miejscowość</label>
                <TownSearch :placeholder="townName" @selected-town="$event.id ? form.town_id = $event.id : form.town_id = townId" />
                <ErrorMessage :error="form.errors.town_id" />
            </div>

            <div class="col-span-6">
                <button type="submit" class="btn-primary">Update</button>
            </div>
        </div>
    </form>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import ErrorMessage from '@/Components/ErrorMessage.vue'
import TownSearch from '@/Components/TownSearch.vue'
import BackButton from '@/Components/BackButton.vue'

const props = defineProps({
    listing: Object,
})

const townName = props.listing.town_name

const townId = props.listing.town_id

const form = useForm({
    name: props.listing.name,
    description: props.listing.description,
    town_id: props.listing.town_id,
})

const update = () => form.put(route('user.listing.update', {listing: props.listing.id}))

</script>
