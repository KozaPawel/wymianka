<template>
    <div class="grid grid-cols-12 gap-2">
        <AdminNavigation class="col-span-12 lg:col-span-2" />

        <Box class="col-span-12 lg:col-span-10">
            <h1 class="page-title">Miejscowości</h1>
            <AddOrEditTown />

            <div class="w-full overflow-x-scroll -m-2 mt-4">
                <table class="bg-light-background-200 w-full table-auto border-collapse">
                    <thead>
                        <tr>
                            <th class="bg-light-background-200 sticky left-0 h-fit text-black">Nazwa</th>
                            <th>Powiat</th>
                            <th>Województwo</th>
                            <th>Szerokość geograficzna (lat)</th>
                            <th>Długość geograficzna (lon)</th>
                            <th />
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="town in props.towns.data" :key="town.id">
                            <td class="px-2 py-3">
                                {{ town.name }}
                            </td>
                            <td class="px-2 py-3">
                                {{ town.county }}
                            </td>
                            <td class="px-2 py-3">
                                {{ town.province }}
                            </td>
                            <td class="px-2 py-3">
                                {{ town.lat }}
                            </td>
                            <td class="px-2 py-3">
                                {{ town.lon }}
                            </td>
                            <td class="px-2 py-3 w-24">
                                <AddOrEditTown :town="town" />
                                <button 
                                    class="btn-danger w-full" 
                                    @click.once="deleteTown(town.id)"
                                >
                                    Usuń
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="flex justify-center w-full mt-5">
                <Pagination :links="props.towns.meta.links" :prev-page-url="props.towns.links.prev" :next-page-url="props.towns.links.next" />
            </div>
        </Box>
    </div>
</template>

<script setup>
import { router } from '@inertiajs/vue3'
import Box from '@/Components/UI/Box.vue'
import Pagination from '@/Components/UI/Pagination.vue'
import AdminNavigation from '@/Components/AdminNavigation.vue'
import AddOrEditTown from '@/Components/AddOrEditTown.vue'

const props = defineProps({
    towns: Object,
})

const deleteTown = (townId) => {
    router.delete(route('admin.town.destroy', {town: townId}))
}

</script>