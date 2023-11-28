<template>
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
                <label class="label">City</label>
                <input v-model="form.city" type="text" class="input" />
                <ErrorMessage :error="form.errors.city" />
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

const props = defineProps({
    listing: Object,
})

const form = useForm({
    name: props.listing.name,
    description: props.listing.description,
    city: props.listing.city,
})

const update = () => form.put(route('user.listing.update', {listing: props.listing.id}))

</script>
