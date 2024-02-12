<template>
    <div class="grid grid-cols-12 gap-2">
        <AdminNavigation class="col-span-12 lg:col-span-2" />

        <Box class="col-span-12 lg:col-span-10">
            <h1 class="page-title">Kategorie</h1>
            <AddCategory />

            <div class="w-full overflow-x-scroll -m-2 mt-4">
                <table class="bg-light-background-200 w-full table-auto border-collapse">
                    <thead>
                        <tr>
                            <th class="bg-light-background-200 sticky left-0 h-fit text-black">Nazwa</th>
                            <th />
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="category in props.categories.data" :key="category.id">
                            <td class="px-2 py-3">
                                {{ category.name }}
                            </td>
                            <td class="px-2 py-3 w-24">
                                <button 
                                    class="btn-danger w-full" 
                                    @click.once="deleteCategory(category.id)"
                                >
                                    Usuń
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="flex justify-center w-full mt-5">
                <Pagination :links="props.categories.meta.links" :prev-page-url="props.categories.links.prev" :next-page-url="props.categories.links.next" />
            </div>
        </Box>
    </div>
</template>

<script setup>
import { router } from '@inertiajs/vue3'
import Box from '@/Components/UI/Box.vue'
import Pagination from '@/Components/UI/Pagination.vue'
import AdminNavigation from '@/Components/AdminNavigation.vue'
import AddCategory from '@/Components/AddCategory.vue'

const props = defineProps({
    categories: Object,
})

const deleteCategory = (categoryId) => {
    router.delete(route('admin.category.destroy', {category: categoryId}))
}

</script>