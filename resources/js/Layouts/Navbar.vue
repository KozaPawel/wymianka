<template>
    <header class="sticky top-0 shadow-md w-full bg-light-background-200">
        <div class="container mx-auto">
            <nav class="flex p-4 items-center justify-between">
                <div class="text-xl font-bold text-light-primary">
                    <Link :href="route('listing.index')">Wymianka</Link>
                </div>

                <form class="w-1/4 " @submit.prevent="search">
                    <div class="flex flex-row items-center justify-center gap-1 ">
                        <input v-model="filterForm.search" type="text" placeholder="Wyszukaj" class="input h-full bg-white w-1/2 transition-all duration-200 ease-in-out focus:w-full" />
                      
                        <button type="submit" class="btn-accent p-0">
                            <svg class="h-9 w-8" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="50" height="50" viewBox="0 0 50 50">
                                <path d="M 21 3 C 11.601563 3 4 10.601563 4 20 C 4 29.398438 11.601563 37 21 37 C 24.355469 37 27.460938 36.015625 30.09375 34.34375 L 42.375 46.625 L 46.625 42.375 L 34.5 30.28125 C 36.679688 27.421875 38 23.878906 38 20 C 38 10.601563 30.398438 3 21 3 Z M 21 7 C 28.199219 7 34 12.800781 34 20 C 34 27.199219 28.199219 33 21 33 C 13.800781 33 8 27.199219 8 20 C 8 12.800781 13.800781 7 21 7 Z" />
                            </svg>
                        </button>
                    </div>
                </form>

                <div v-if="user" class="flex items-center gap-4">
                    <Link 
                        :href="route('user.listing.create')"
                        class="btn-primary"
                    >
                        Dodaj ogłoszenie
                    </Link>
                    <Link 
                        :href="route('user.listing.index')" 
                        class="accent-text font-bold"
                    >
                        {{ user.name }}
                    </Link>
                    <div>
                        <Link 
                            :href="route('logout')" 
                            method="delete" 
                            as="button" 
                            class="accent-text"
                        >
                            Wyloguj się
                        </Link>
                    </div>
                </div>
                <div v-else class="flex items-center gap-4">
                    <Link 
                        :href="route('register')" 
                        class="accent-text"
                    >
                        Zarejestruj się
                    </Link>
                    
                    <Link 
                        :href="route('login')" 
                        class="btn-primary"
                    >
                        Zaloguj się
                    </Link>
                </div>
            </nav>
        </div>
    </header>

    <main class="container mx-auto p-4 w-full">
        <div v-if="flashMessage" class="mb-4 p-2 border rounded-md bg-light-secondary shadow-sm">
            {{ flashMessage }}
        </div>
        <slot />
    </main>
</template>

<script setup>
import { computed, reactive } from 'vue'
import { Link, usePage, router } from '@inertiajs/vue3'

const page = usePage()

const props = defineProps({
    filters: Object,
})

const categoryList = computed(
    () => page.props.filters.categories,
)

const flashMessage = computed(
    () => page.props.flash.success,
)

const user = computed(
    () => page.props.user,
)

const filterForm = reactive({
    search: props.filters.search ?? '',
    categories: categoryList,
})

// const homepage = () => {
//     router.get(route('listing.index')),
//     filterForm.search = ''
// }

const search = () => {
    router.get(
        route('listing.index'),
        filterForm,
        {
            preserveState: true,
            preserveScroll: true,
        },
    ),
    filterForm.search = ''
}
</script>