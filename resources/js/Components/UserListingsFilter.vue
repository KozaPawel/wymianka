<template>
    <form>
        <div class="flex flex-wrap mb-4 mt-4 gap-2">
            <div class="flex flex-nowrap items-center gap-2">
                <input
                    id="deleted" 
                    v-model="filterForm.deleted"
                    type="checkbox" 
                    class="input-checkbox"
                />
                <label for="deleted" class="hover:cursor-pointer hover:underline">Usunięte</label>
            </div>
            <div>
                <select v-model="filterForm.by" class="w-30">
                    <option value="created_at">Dodano</option>
                    <option value="updated_at">Edytowano</option>
                </select>
                <select v-model="filterForm.order" class="w-30">
                    <option value="desc">- od najnowszych</option>
                    <option value="asc">- od najstarszych</option>
                </select>
            </div>
        </div>
    </form>
</template>

<script setup>
import { reactive, watch } from 'vue'
import { router } from '@inertiajs/vue3'
import { debounce } from 'lodash'

const props = defineProps({
    filters: Object,
})

const filterForm = reactive({
    deleted: props.filters.deleted ?? false,
    by: props.filters.by ?? 'created_at',
    order: props.filters.order ?? 'desc',
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