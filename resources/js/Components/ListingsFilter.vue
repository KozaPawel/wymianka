<template>
    <div>
        <form @submit.prevent="filter">
            <div class="box mb-4 flex flex-wrap flex-col gap-2 items-start w-full ">
                <h2 class="text-2xl font-medium">Filtry</h2>
                
                <div class="w-full">
                    <Disclosure v-slot="{ open }">
                        <DisclosureButton
                            class="btn-accent flex items-center w-full justify-between rounded-lg"
                        >
                            <span class="text-xl">Kategoria</span>
                            <ChevronDownIcon
                                :class="open ? 'rotate-180 transform' : ''"
                                class="h-5 w-5 transition duration-100 ease-in"
                            />
                        </DisclosureButton>
                        <DisclosurePanel class="pl-2 pb-2 pt-4">
                            <div v-for="category in categories" :key="category.id" class="flex flex-nowrap items-center gap-2">
                                <input
                                    :id="category.id" 
                                    v-model="filterForm.categories"
                                    :value="category.id"
                                    type="checkbox" 
                                    class="input-checkbox"
                                />
                                <label :for="category.id" class="hover:cursor-pointer hover:underline break-words">{{ category.name }}</label>
                            </div>
                        </DisclosurePanel>
                    </Disclosure>
                </div>
                
                <div class="flex flex-col items-center">
                    <button type="submit" class="w-fit btn-accent">Zastosuj filtry</button>
                    <button type="reset" class="w-fit hover:underline text-sm mt-2" @click="reset">Wyczyść filtry</button>
                </div>
            </div>
        </form>
    </div>
</template>

<script setup>
import { reactive, computed } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue'
import { ChevronDownIcon } from '@heroicons/vue/20/solid'

const page = usePage()

const searchValue = computed(
    () => page.props.filters.search,
)

const townValue = computed(
    () => page.props.filters.town,
)

const props = defineProps({
    filters: Object,
    categories: Object,
})

const filterForm = reactive({
    search: searchValue,
    categories: props.filters.categories ?? [],
    town: townValue,
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
    filterForm.categories = [],
    filter()
}
</script>