<template>
    <form>
        <div class="flex flex-wrap flex-row items-center mb-4 mt-4 gap-2">
            <div class="flex">
                <select v-model="filterForm.by" class="select w-32 rounded-r-none">
                    <option value="created_at">Dodano</option>
                    <option value="updated_at">Edytowano</option>
                </select>
                <select v-model="filterForm.order" class="select w-44 rounded-l-none border-l-0">
                    <option value="desc">- od najnowszych</option>
                    <option value="asc">- od najstarszych</option>
                </select>
            </div>
            <div v-if="page.props.filters.status === 'all'" class="flex flex-nowrap items-center gap-2">
                <input
                    id="deleted" 
                    v-model="filterForm.deleted"
                    type="checkbox" 
                    class="input-checkbox"
                />
                <label for="deleted" class="hover:cursor-pointer hover:underline">Usunięte</label>
            </div>
        </div>
        <!-- <div>
            <select v-model="filterForm.status" class="select w-full md:w-56">
                <option value="all">Wystawione przedmioty</option>
                <option value="in_progress">Wymiany w trakcie</option>
                <option value="ended">Zakończone wymiany</option>
            </select>
        </div> -->
    </form>
</template>

<script setup>
import { reactive, watch } from 'vue'
import { router, usePage } from '@inertiajs/vue3'
import { debounce } from 'lodash'

const page = usePage()

const props = defineProps({
    filters: Object,
})

const filterForm = reactive({
    deleted: props.filters.deleted ?? false,
    by: props.filters.by ?? 'created_at',
    order: props.filters.order ?? 'desc',
    status: props.filters.status ?? 'all',
})

watch(
    filterForm, debounce(() => router.get(
        route('user.listing.index'),
        filterForm,
        { 
            preserveState: true,
            preserveScroll: true,    
        },
    ), 500),
)
</script>