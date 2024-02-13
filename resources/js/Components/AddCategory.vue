<template>
    <button class="btn-primary mt-2" @click="openModal">
        Dodaj nową kategorię
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
                                <p class="break-words">Nowa kategoria</p>
                                <button type="button" class="ml-14 md:ml-0" @click="closeModal">
                                    <XMarkIcon class="h-8 w-8 hover:cursor-pointer" />
                                </button>
                            </DialogTitle>
                            <div class="flex flex-col mt-2">
                                <div class="flex flex-col">
                                    <label class="label"> Nazwa </label>
                                    <input v-model="form.name" type="text" class="input" required />
                                    <ErrorMessage :error="form.errors.name" />
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
                                    @click="createCategory"
                                >
                                    Dodaj kategorię
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

const isOpen = ref(false)
  
function closeModal() {
    isOpen.value = false
    form.name = ''
    form.errors = ''
}

function openModal() {
    isOpen.value = true
}

const form = useForm({
    name: '',
})

const createCategory = () => {
    form.post(route('admin.category.store'))
}

</script>