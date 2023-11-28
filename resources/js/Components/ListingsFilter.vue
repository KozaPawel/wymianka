<template>
    <div>
        <form @submit.prevent="filter">
            <div class="mb-4 flex flex-wrap gap-2">
                <div class="flex flex-nowrap items-center">
                    <input v-model="filterForm.search" type="text" placeholder="Search" />
                </div>
                <!-- zamienić na sortowanie po ocenach użytkowników -->
                <!-- <div class="flex flex-nowrap items-center">
                    <select>
                        <option :value="null">Beds</option>
                    </select>
                    <select>
                        <option :value="null">Beds</option>
                    </select>
                </div> -->
                <div v-for="category in categories" :key="category.id" class="flex flex-nowrap items-center gap-2">
                    <input
                        :id="category.id" 
                        v-model="filterForm.categories"
                        :value="category.id"
                        type="checkbox" 
                        class="h-4 w-4 rounded border-gray-300 text-light-accent hover:cursor-pointer hover:border-light-accent focus:ring-offset-0 focus:ring-transparent"
                    />
                    <label :for="category.id" class="hover:cursor-pointer hover:underline">{{ category.name }}</label>
                </div>

                <button type="submit">Filtruj</button>
                <button type="reset" @click="reset">Wyczyść filtry</button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { reactive, watch } from 'vue'
import { useForm, router } from '@inertiajs/vue3'

const props = defineProps({
    filters: Object,
    categories: Object,
})

const filterForm = reactive({
    search: props.filters.search ?? null,
    categories: props.filters.categories ?? [],
})

const filter = () => {
    router.get(
        route('listing.index'),
        filterForm,
        {
            preserveState: true,
            preserveScroll: true,
        },
    )
}

const reset = () => {
    filterForm.search = null,
    filterForm.categories = [],
    filter()
}
</script>