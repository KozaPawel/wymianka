<template>
    <form @submit.prevent="create">
        <div class="grid grid-cols-6 gap-4">
            <div class="col-span-6">
                <label class="label">Nazwa</label>
                <input v-model="form.name" type="text" class="input" required />
                <ErrorMessage :error="form.errors.name" />
            </div>

            <div class="col-span-6">
                <label class="label">Opis</label>
                <input v-model="form.description" type="text" class="input" required />
                <ErrorMessage :error="form.errors.description" />
            </div>

            <div class="col-span-6">
                <label class="label">City</label>
                <input v-model="form.city" type="text" class="input" required />
                <ErrorMessage :error="form.errors.city" />
            </div>

            <div class="col-span-6">
                <label class="label">Kategoria</label>
                <select v-model="form.category_id" required class="input lg:w-1/4">
                    <option disabled value="">Wybierz kategorię</option>
                    <option v-for="category in categories" :key="category.id" :value="category.id">
                        {{ category.name }}
                    </option>
                </select>
            </div>

            <div class="col-span-6">
                <button type="submit" class="btn-primary">Create</button>
            </div>
        </div>
    </form>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import ErrorMessage from '@/Components/ErrorMessage.vue'

defineProps({
    categories: Object,
})

const form = useForm({
    name: '',
    description: '',
    city: '',
    category_id: '',
})

const create = () => form.post(route('user.listing.store'))

</script>
