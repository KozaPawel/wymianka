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
                            <div class="h-9 w-9 flex items-center justify-center">
                                <MagnifyingGlassIcon class="h-6" />
                            </div>
                        </button>
                    </div>
                </form>

                <div v-if="user" class="text-right">
                    <Menu as="div" class="relative inline-block text-left">
                        <div>
                            <MenuButton 
                                class="text-accent inline-flex w-full justify-center px-4 py-2 text-sm font-medium"
                            >
                                {{ user.name }}
                                <ChevronDownIcon
                                    class="menu-icon -mr-1"
                                    aria-hidden="true"
                                />
                            </MenuButton>
                        </div>

                        <transition
                            enter-active-class="transition duration-100 ease-out"
                            enter-from-class="transform scale-95 opacity-0"
                            enter-to-class="transform scale-100 opacity-100"
                            leave-active-class="transition duration-75 ease-in"
                            leave-from-class="transform scale-100 opacity-100"
                            leave-to-class="transform scale-95 opacity-0"
                        >
                            <MenuItems
                                class="absolute right-0 mt-2 w-56 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black/5 focus:outline-none"
                            >
                                <div class="px-1 py-1">
                                    <Link :href="route('user.listing.index')"> 
                                        <MenuItem>
                                            <button class="menu-item">
                                                <UserIcon
                                                    class="menu-icon"
                                                    aria-hidden="true"
                                                />
                                                Profil
                                            </button>
                                        </MenuItem>
                                    </Link>

                                    <Link :href="route('user.listing.create')"> 
                                        <MenuItem>
                                            <button class="menu-item">
                                                <PlusIcon
                                                    class="menu-icon"
                                                    aria-hidden="true"
                                                />
                                                Dodaj ogłoszenie
                                            </button>
                                        </MenuItem>
                                    </Link>
                                </div>

                                <div class="px-1 py-1">
                                    <Link
                                        :href="route('logout')" 
                                        method="delete"
                                        as="button"
                                        class="w-full"
                                    > 
                                        <MenuItem v-slot="{ active }">
                                            <button class="menu-item hover:bg-[#C1C4C6]">
                                                <ArrowRightOnRectangleIcon
                                                    :active="active"
                                                    class="menu-icon"
                                                    aria-hidden="true"
                                                />
                                                Wyloguj
                                            </button>
                                        </MenuItem>
                                    </Link>
                                </div>
                            </MenuItems>
                        </transition>
                    </Menu>
                </div>

                <div v-else class="flex items-center gap-4">
                    <Link 
                        :href="route('register')" 
                        class="text-accent"
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
        <slot />
    </main>
</template>

<script setup>
import { computed, reactive, watch } from 'vue'
import { Link, usePage, router } from '@inertiajs/vue3'
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue' 
import { MagnifyingGlassIcon, ChevronDownIcon, UserIcon, PlusIcon, ArrowRightOnRectangleIcon } from '@heroicons/vue/20/solid'
import { useToast } from 'vue-toastification'

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

const toast = useToast()

const user = computed(
    () => page.props.user,
)

const filterForm = reactive({
    search: props.filters.search ?? '',
    categories: categoryList,
})

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

watch(
    flashMessage, () => {
        if(flashMessage.value !== null) {
            toast.success(flashMessage.value)
            page.props.flash.success = null
        }
    },
)
</script>