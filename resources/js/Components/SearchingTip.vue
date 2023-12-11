<template>
    <InformationCircleIcon class="h-8 w-8 hover:cursor-pointer text-gray-400" @click="openModal" />

    <TransitionRoot appear :show="isOpen" as="template">
        <Dialog as="div" class="relative z-10" @close="closeModal">
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
                                <p>Wyszukiwanie ogłoszeń</p>
                                <button type="button" class="mt-14 ml-14 md:mt-0 md:ml-0" @click="closeModal">
                                    <XMarkIcon class="h-8 w-8 hover:cursor-pointer" />
                                </button>
                            </DialogTitle>
                            <div class="mt-2">
                                <p class="text-sm text-gray-700">
                                    Pierwsze pole służy do wyszukiwania po tytule ogłoszenia.
                                    Drugie pole wyszukuje miejscowość, należy pamiętać o kolejności tj. miejscowość powiat województwo
                                    np: złotoryja złotoryjski dolnośląskie.
                                </p>
                            </div>
  
                            <div class="mt-4">
                                <button
                                    type="button"
                                    class="btn-primary"
                                    @click="closeModal"
                                >
                                    Zrozumiałem
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
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
} from '@headlessui/vue'
import { InformationCircleIcon, XMarkIcon } from '@heroicons/vue/20/solid'  

const isOpen = ref(false)
  
function closeModal() {
    isOpen.value = false
}
function openModal() {
    isOpen.value = true
}
</script>
  