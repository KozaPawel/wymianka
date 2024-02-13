<template>
    <button class="mb-2" :class="{'btn-accent w-full': props.town, 'btn-primary': !props.town}" @click="openModal">
        {{ props.town ? "Edytuj" : "Dodaj nową miejscowość" }}
    </button>

    <TransitionRoot appear :show="isOpen" as="template">
        <Dialog as="div" class="relative z-50" @close="closeModal">
            <TransitionChild
                as="template"
                enter="duration-300 ease-out"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="duration-200 ease-in"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div class="fixed inset-0 bg-black/25" />
            </TransitionChild>
  
            <div class="fixed inset-0 overflow-y-auto">
                <div
                    class="flex min-h-full items-center justify-center p-4 text-center"
                >
                    <TransitionChild
                        as="template"
                        enter="duration-300 ease-out"
                        enter-from="opacity-0 scale-95"
                        enter-to="opacity-100 scale-100"
                        leave="duration-200 ease-in"
                        leave-from="opacity-100 scale-100"
                        leave-to="opacity-0 scale-95"
                    >
                        <DialogPanel
                            class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all"
                        >
                            <DialogTitle
                                as="h3"
                                class="flex flex-row items-center justify-between text-lg font-medium leading-6"
                            >
                                <p class="break-words">Nowa miejscowość</p>
                                <button type="button" class="ml-14 md:ml-0" @click="closeModal">
                                    <XMarkIcon class="h-8 w-8 hover:cursor-pointer" />
                                </button>
                            </DialogTitle>
                            <div class="flex flex-col mt-2">
                                <div class="flex flex-col">
                                    <label class="label"> Nazwa </label>
                                    <input v-model="form.name" type="text" class="input mb-2" required />
                                    <ErrorMessage :error="form.errors.name" />

                                    <label class="label"> Powiat </label>
                                    <input v-model="form.county" type="text" class="input mb-2" required />
                                    <ErrorMessage :error="form.errors.county" />

                                    <label class="label"> Województwo </label>
                                    <input v-model="form.province" type="text" class="input mb-2" required />
                                    <ErrorMessage :error="form.errors.province" />

                                    <div class="flex flex-row gap-2">
                                        <div>
                                            <label class="label"> Szerokość geograficzna </label>
                                            <input v-model="form.lat" type="text" class="input" required />
                                            <ErrorMessage :error="form.errors.lat" />
                                        </div>

                                        <div>
                                            <label class="label"> Długość geograficzna </label>
                                            <input v-model="form.lon" type="text" class="input" required />
                                            <ErrorMessage :error="form.errors.lon" />
                                        </div>
                                    </div>
                                </div>
                            </div>
  
                            <div class="flex flex-row gap-2 mt-4">
                                <button
                                    type="button"
                                    class="btn-accent"
                                    @click="closeModal"
                                >
                                    Anuluj
                                </button>
                                <button
                                    type="button"
                                    class="btn-primary"
                                    @click="props.town ? updateTown(town.id) : createTown()"
                                >
                                    {{ props.town ? "Edytuj miejscowość" : "Dodaj miejscowość" }}
                                </button>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script setup>
import { ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import ErrorMessage from '@/Components/ErrorMessage.vue'
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
} from '@headlessui/vue'
import { XMarkIcon } from '@heroicons/vue/20/solid'  

const props = defineProps({
    town: Object,
})

const isOpen = ref(false)
  
function closeModal() {
    isOpen.value = false
}

function openModal() {
    isOpen.value = true
}

const form = useForm({
    name: props.town ? props.town.name : '',
    county: props.town ? props.town.county : '',
    province: props.town ? props.town.province : '',
    lat: props.town ? props.town.lat : '',
    lon: props.town ? props.town.lon : '',
})

const createTown = () => {
    form.post(route('admin.town.store'))
}

const updateTown = (townId) => {
    form.put(route('admin.town.update', {town: townId}))
}
</script>