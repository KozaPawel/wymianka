<template>
    <div class="grid grid-cols-12 gap-2">
        <AdminNavigation class="col-span-12 lg:col-span-2" />

        <Box class="col-span-12 lg:col-span-10">
            <h1 class="page-title">Opinie</h1>
            <div class="w-full overflow-x-scroll -m-2 mt-4">
                <table class="bg-light-background-200 w-full table-auto border-collapse">
                    <thead>
                        <tr>
                            <th class="bg-light-background-200 sticky left-0 h-fit text-black">Użytkownik</th>
                            <th>Ocena</th>
                            <th>Opis</th>
                            <th />
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="review in props.reviews.data" :key="review.id">
                            <td class="px-2 py-3 w-32">
                                {{ review.made_by.name }}
                            </td>
                            <td class="px-2 py-3">
                                {{ review.rating }}
                            </td>
                            <td class="px-2 py-3">
                                {{ review.summary }}
                            </td>
                            <td class="px-2 py-3 w-24">
                                <button 
                                    class="btn-danger w-full" 
                                    @click.once="deleteReview(review.id)"
                                >
                                    Usuń
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="flex justify-center w-full mt-5">
                <Pagination :links="props.reviews.links" :prev-page-url="props.reviews.prev_page_url" :next-page-url="props.reviews.next_page_url" />
            </div>
        </Box>
    </div>
</template>

<script setup>
import { router } from '@inertiajs/vue3'
import Box from '@/Components/UI/Box.vue'
import Pagination from '@/Components/UI/Pagination.vue'
import AdminNavigation from '@/Components/AdminNavigation.vue'

const props = defineProps({
    reviews: Object,
})

const deleteReview = (reviewId) => {
    router.delete(route('admin.review.destroy', {review: reviewId}))
}
</script>