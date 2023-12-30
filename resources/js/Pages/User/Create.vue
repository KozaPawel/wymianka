<template>
    <form @submit.prevent="create">
        <div class="grid grid-cols-6 gap-4">
            <div class="col-span-6">
                <label class="label">Tytuł ogłoszenia</label>
                <input v-model="form.name" type="text" class="input" required />
                <ErrorMessage :error="form.errors.name" />
            </div>

            <div class="col-span-6">
                <label class="label">Opis</label>
                <textarea v-model="form.description" type="text" class="input h-40" required />
                <ErrorMessage :error="form.errors.description" />
            </div>

            <div class="col-span-6">
                <label class="label">Miejscowość</label>
                <TownSearch class="lg:w-1/4" @selected-town="form.town_id = $event.id" />
                <ErrorMessage :error="form.errors.town_id" />
            </div>

            <div class="col-span-6">
                <label class="label">Kategoria</label>
                <select v-model="form.category_id" required class="select lg:w-1/4" :class="{'text-gray-600': form.category_id === ''}">
                    <option disabled value="">Wybierz kategorię</option>
                    <option v-for="category in categories" :key="category.id" :value="category.id">
                        {{ category.name }}
                    </option>
                </select>
            </div>


            <div class="col-span-6">
                <button type="submit" class="btn-primary">
                    Dodaj ogłoszenie
                </button>
            </div>
        </div>
    </form>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import ErrorMessage from '@/Components/ErrorMessage.vue'
import TownSearch from '@/Components/TownSearch.vue'

defineProps({
    categories: Object,
})

const form = useForm({
    name: '',
    description: '',
    category_id: '',
    town_id: '',
})

const create = () => form.post(route('user.listing.store'))

</script>
