<template>
    <TransitionRoot appear :show="isModalOpen" as="template">
        <Dialog class="relative z-50 w-full" @close="closeModal">
            <div class="fixed inset-0 w-screen">
                <TransitionChild
                    as="template"
                    enter="duration-300 ease-out"
                    enter-from="opacity-0 scale-95"
                    enter-to="opacity-100 scale-100"
                    leave="duration-200 ease-in"
                    leave-from="opacity-100 scale-100"
                    leave-to="opacity-0 scale-95"
                >
                    <DialogPanel class="w-full h-full bg-light-background p-14 ">
                        <DialogTitle>
                            <button type="button" @click="closeModal">
                                <XMarkIcon class="h-8 w-8 hover:cursor-pointer" />
                            </button>
                        </DialogTitle>

                        <Carousel v-if="numberOfImages">
                            <Slide v-for="image in props.images" :key="image.id">
                                <div>
                                    <img :src="image.source" class="object-scale-down w-fit h-[43rem] hover:cursor-pointer" />
                                </div>
                            </Slide>
                
                            <template #addons>
                                <Navigation 
                                    v-if="numberOfImages > 1"
                                    class="!carousel-arrow"
                                />
                                <Pagination
                                    v-if="numberOfImages > 1"
                                />
                            </template>
                        </Carousel>
                    </DialogPanel>
                </TransitionChild>
            </div>
        </Dialog>
    </TransitionRoot>

    <Carousel v-if="numberOfImages">
        <Slide v-for="image in props.images" :key="image.id" class="h-96 w-fit hover:cursor-pointer">
            <div @click="openModal">
                <img :src="image.source" class="h-96 w-fit" />
            </div>
        </Slide>
                
        <template #addons>
            <Navigation 
                v-if="numberOfImages > 1"
                class="!carousel-arrow"
            />
            <Pagination v-if="numberOfImages > 1" />
        </template>
    </Carousel>
            
    <div v-else class="w-full text-center font-medium">
        Brak zdjęć
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { Carousel, Navigation, Pagination, Slide } from 'vue3-carousel'
import 'vue3-carousel/dist/carousel.css'
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
} from '@headlessui/vue'
import { XMarkIcon } from '@heroicons/vue/20/solid'

const props = defineProps({
    images: Object,
})

const isModalOpen = ref(false)

const numberOfImages = props.images.length

const closeModal = () => isModalOpen.value = false

const openModal = () => isModalOpen.value = true

</script>