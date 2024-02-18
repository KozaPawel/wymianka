<template>
    <header class="sticky top-0 z-50 shadow-md w-full bg-light-background-200">
        <div class="container mx-auto">
            <nav class="flex p-4 items-center justify-between">
                <div class="text-xl font-bold text-light-primary">
                    <Link :href="route('listing.index')">Wymianka</Link>
                </div>

                <div v-if="user" class="flex flex-row items-center gap-1 text-right">
                    <Link :href="route('notification.index')" class="relative pr-1 py-1">
                        <BellIcon class=" h-6 w-6" />
                        <div v-if="notificationCount !== 0" class="absolute top-0 right-0 rounded-full w-4 h-4 text-center text-xs text-light-background-200 bg-light-danger">
                            {{ notificationCount }}
                        </div>
                    </Link>
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
                                class="absolute right-0 mt-2 w-56 origin-top-right divide-y divide-gray-100 rounded-md bg-light-background shadow-lg ring-1 ring-black/5 focus:outline-none"
                            >
                                <div class="px-1 py-1">
                                    <Link v-if="user.isAdmin" :href="route('admin.listings')">
                                        <MenuItem v-slot="{ active }">
                                            <button :class="[active ? 'bg-light-hover-gray' : '', 'menu-item' ]">
                                                <ComputerDesktopIcon
                                                    class="menu-icon"
                                                    aria-hidden="true"
                                                />
                                                Panel Administratora
                                            </button>
                                        </MenuItem>
                                    </Link>
                                    <Link :href="route('user.listing.index', { status: 'all'})"> 
                                        <MenuItem v-slot="{ active }">
                                            <button :class="[active ? 'bg-light-hover-gray' : '', 'menu-item' ]">
                                                <ListBulletIcon
                                                    class="menu-icon"
                                                    aria-hidden="true"
                                                />
                                                Ogłoszenia
                                            </button>
                                        </MenuItem>
                                    </Link>
                                    
                                    <Link :href="route('user.listing.create')"> 
                                        <MenuItem v-slot="{ active }">
                                            <button :class="[active ? 'bg-light-hover-gray' : '', 'menu-item' ]">
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
                                    <Link :href="route('user.listing.index', { status: 'in_progress'})"> 
                                        <MenuItem v-slot="{ active }">
                                            <button :class="[active ? 'bg-light-hover-gray' : '', 'menu-item' ]">
                                                <ArrowPathIcon
                                                    class="menu-icon"
                                                    aria-hidden="true"
                                                />
                                                Wymiany w trakcie
                                            </button>
                                        </MenuItem>
                                    </Link>

                                    <Link :href="route('user.listing.index', { status: 'ended'})"> 
                                        <MenuItem v-slot="{ active }">
                                            <button :class="[active ? 'bg-light-hover-gray' : '', 'menu-item' ]">
                                                <ArrowsRightLeftIcon
                                                    class="menu-icon"
                                                    aria-hidden="true"
                                                />
                                                Zakończone wymiany
                                            </button>
                                        </MenuItem>
                                    </Link>
                                </div>
                                
                                <div class="px-1 py-1">
                                    <Link :href="route('user.show', { user: user})"> 
                                        <MenuItem v-slot="{ active }">
                                            <button :class="[active ? 'bg-light-hover-gray' : '', 'menu-item' ]">
                                                <UserIcon
                                                    class="menu-icon"
                                                    aria-hidden="true"
                                                />
                                                Profil
                                            </button>
                                        </MenuItem>
                                    </Link>
                                    
                                    <Link :href="route('chat.room.index')"> 
                                        <MenuItem v-slot="{ active }">
                                            <button :class="[active ? 'bg-light-hover-gray' : '', 'menu-item' ]">
                                                <ChatBubbleOvalLeftEllipsisIcon
                                                    class="menu-icon"
                                                    aria-hidden="true"
                                                />
                                                Wiadomości
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
                                            <button :class="[active ? 'bg-[#C1C4C6]' : '', 'menu-item hover:bg-[#C1C4C6]' ]">
                                                <ArrowRightOnRectangleIcon
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
import { computed, watch } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'
import { Menu, MenuButton, MenuItems, MenuItem } from '@headlessui/vue' 
import { 
    ChevronDownIcon, 
    PlusIcon, 
    ArrowRightOnRectangleIcon, 
    ArrowsRightLeftIcon,
    ArrowPathIcon,
    ListBulletIcon,
    ComputerDesktopIcon,
} from '@heroicons/vue/20/solid'
import { BellIcon, UserIcon, ChatBubbleOvalLeftEllipsisIcon } from '@heroicons/vue/24/outline'
import { useToast } from 'vue-toastification'

const page = usePage()

const flashMessage = computed(
    () => page.props.flash.success,
)

const toast = useToast()

const user = computed(
    () => page.props.loggedUser,
)

const notificationCount = computed(
    () => Math.min(page.props.loggedUser.notificationCount, 9),
)

watch(
    flashMessage, () => {
        if(flashMessage.value !== null) {
            toast.success(flashMessage.value)
            page.props.flash.success = null
        }
    },
)
</script>