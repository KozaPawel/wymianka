<template>
    <header class="sticky top-0 shadow-md w-full bg-light-background-200">
        <div class="container mx-auto">
            <nav class="flex p-4 items-center justify-between">
                <div class="text-xl font-bold text-light-primary">
                    <Link :href="route('listing.index')">Wymianka</Link> &nbsp;
                </div>
                <div v-if="user" class="flex items-center gap-4">
                    <Link :href="route('user.listing.create')" class="btn-primary">Dodaj ogłoszenie</Link>
                    <Link :href="route('user.listing.index')" class="text-gray-800 text-md font-bold">
                        {{ user.name }}
                    </Link>
                    <div>
                        <Link :href="route('logout')" method="delete" as="button" class="text-gray-800">Wyloguj się</Link>
                    </div>
                </div>
                <div v-else class="flex items-center gap-4">
                    <Link :href="route('register')" class="text-gray-800">Zarejestruj się</Link>
                    <Link :href="route('login')" class="btn-primary">Zaloguj się</Link>
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
import { computed } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'

const page = usePage()

const flashMessage = computed(
    () => page.props.flash.success,
)

const user = computed(
    () => page.props.user,
)
</script>