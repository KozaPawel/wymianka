<template>
    <BackButton />
    
    <Box v-if="listing.images.length < 6">
        <template #header>
            Prześlij nowe zdjęcia 
            <p class="text-sm font-normal">(maksymalny rozmiar zdjęcia 5MB)</p>
        </template>
        
        <form @submit.prevent="upload">
            <section class="flex items-center flex-col md:flex-row gap-2 my-4 w-full">
                <input 
                    class="border-2 rounded-md file:px-4 file:py-2 border-gray-300 
                    file:text-gray-700 file:border-0 file:bg-gray-300 file:font-medium file:mr-4
                    hover:border-gray-400 file:hover:bg-gray-400 file:hover:cursor-pointer hover:cursor-pointer w-full md:w-1/2" 
                    type="file" multiple @input="addFiles"
                />
                <div class="flex flex-row gap-2 justify-between md:justify-start w-full">
                    <button 
                        type="submit" 
                        class="btn-accent disabled:opacity-50 disabled:cursor-not-allowed w-full md:w-24" 
                        :disabled="!canUpload"
                    >
                        Wyślij
                    </button>
                    <button
                        type="reset" 
                        class="btn-accent disabled:opacity-50 disabled:cursor-not-allowed w-full md:w-24" 
                        :disabled="!canUpload" 
                        @click="reset"
                    >
                        Wyczyść
                    </button>
                </div>
            </section>
            <ErrorMessage v-if="imageErrors.length" :error="imageErrors[0]" />
        </form>
    </Box>

    <Box v-if="listing.images.length" class="mt-4">
        <template #header>
            Zdjęcia 
            <p class="text-sm font-normal">(maksymalna ilość 6)</p>
        </template>
        <section class="mt-4 grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
            <div
                v-for="image in listing.images" :key="image.id" 
                class="flex flex-col justify-between"
            >
                <img :src="image.source" class="rounded-md mb-2 object-cover w-auto h-80" />
                <button class="btn-accent" @click.once="deleteImage(listing, image)">Usuń</button>
            </div>
        </section>
    </Box>
</template>
<script setup>
import { computed } from 'vue'
import { useForm, router } from '@inertiajs/vue3'
import NProgress from 'nprogress'
import Box from '@/Components/UI/Box.vue'
import ErrorMessage from '@/Components/ErrorMessage.vue'
import BackButton from '@/Components/BackButton.vue'

const props = defineProps({
    listing: Object,
})

router.on('progress', (event) => {
    if(event.detail.progress.percentage) {
        NProgress.set((event.detail.progress.percentage / 100) * 0.9)
    }
})

const form = useForm({
    images: [],
})

const imageErrors = computed(() => Object.values(form.errors))

const canUpload = computed(() => form.images.length)

const upload = () => {
    if(form.images.length + props.listing.images.length <=6) {
        form.post(route('user.listing.image.store', {listing: props.listing.id}),
            {
                onSuccess: () => form.reset('images'),
            },
        )
    } else {
        imageErrors.value.push('Przedmiot może mieć maksymalnie 6 zdjęć')
    }
    
    reset()
}

const addFiles = (event) => {
    for (const image of event.target.files) {
        form.images.push(image)
    }
}

const reset = () => {
    form.reset('images')
}

function deleteImage(listing, image) {
    router.delete(route('user.listing.image.destroy', {listing: listing.id, image: image.id}))
}

</script>