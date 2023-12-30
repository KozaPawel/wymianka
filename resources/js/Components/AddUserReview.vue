<template>
    <div class="flex md:items-center md:justify-center">
        <button class="btn-accent w-full" @click="openModal">
            Oceń wymianę
        </button>
    </div>

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
                                <p class="break-words">Oceń współpracę z użytkownikiem {{ props.listing.trade_for.user.name }}</p>
                                <button type="button" class="ml-14 md:ml-0" @click="closeModal">
                                    <XMarkIcon class="h-8 w-8 hover:cursor-pointer" />
                                </button>
                            </DialogTitle>
                            <div class="flex flex-col mt-2">
                                <div class="flex flex-col">
                                    <div class="flex flex-row">
                                        <StarIcon
                                            v-for="star in stars" :key="star" 
                                            class="w-9 h-8 hover:cursor-pointer" 
                                            :class="{'text-yellow-400': star <= selectedStar, 'hover:text-yellow-400, text-yellow-400': star <= hoverStar, 'text-black': star > hoverStar && hoverStar !== 0}"
                                            value="star[index]"
                                            @click="chooseStar(star)"
                                            @mouseover="hoveredStar(star)" @mouseout="resetHoveredStar"
                                        />
                                    </div>
                                    <ErrorMessage :error="form.errors.rating" />

                                    <p v-if="selectedStar > 0" class="text-md mt-1 ml-1">
                                        {{ selectedStar }} - {{ starsDescription[selectedStar - 1] }}
                                    </p>
                                </div>

                                <label class="text-sm text-gray-600 mt-2">Opis (opcjonalnie)</label>
                                <textarea v-model="form.summary" class="input h-24" />
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
                                    @click="createReview"
                                >
                                    Wystaw ocenę
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
import { StarIcon, XMarkIcon } from '@heroicons/vue/20/solid'  

const props = defineProps({
    listing: Object,
})

const stars = [1,2,3,4,5]

const starsDescription = [
    'naganna',
    'słaba',
    'przeciętna',
    'dobra',
    'idealna',
]

const selectedStar = ref(0)

const hoverStar = ref(0)

const chooseStar = (value) => {
    selectedStar.value = value
    form.rating = value
}

const hoveredStar = (value) => hoverStar.value = value

const resetHoveredStar = () => hoverStar.value = 0

const isOpen = ref(false)
  
function closeModal() {
    isOpen.value = false
    selectedStar.value = 0
    form.rating = 0
    form.summary = ''
    form.errors = {}
}
function openModal() {
    isOpen.value = true
}

const form = useForm({
    rating: '',
    summary: '',
    trade_id: props.listing.trade_id,
    user_id: props.listing.trade_for.user.id ?? null,
    by_user_id: props.listing.user.id,
})

const createReview = () => form.post(route('user.review.store'))

</script>