<template>
    <form @submit.prevent="register">
        <div class="w-1/2 mx-auto">
            <div>
                <label class="label" for="name">Nazwa</label>
                <input id="name" v-model="form.name" type="text" class="input" required />
            </div>
            <div class="mt-4">
                <label class="label" for="email">E-mail</label>
                <input id="email" v-model="form.email" type="email" class="input" required />
                <ErrorMessage v-if="form.errors.email" :error="form.errors.email" />
            </div>
            <div class="mt-4">
                <label class="label" for="password">Hasło</label>
                <input id="password" v-model="form.password" type="password" class="input" required />
            </div>
            <div class="mt-4">
                <label class="label" for="password_confirmation">Potwierdź hasło</label>
                <input id="password_confirmation" v-model="form.password_confirmation" type="password" class="input" required />
                <ErrorMessage v-if="form.errors.password" :error="form.errors.password" />
            </div>
            <div class="mt-6">
                <button class="btn-primary w-full md:w-1/3" type="submit">Zarejestruj się</button>
            </div>
            <div class="mt-3 text-center md:text-left text-sm">
                <Link :href="route('login')">
                    Masz już konto? 
                    <span class="font-bold">Zaloguj się</span>
                </Link>
            </div>
        </div>
    </form>
</template>

<script setup>
import { useForm, Link } from '@inertiajs/vue3'
import ErrorMessage from '@/Components/ErrorMessage.vue'

const form = useForm({
    name: null,
    email: null,
    password: null,
    password_confirmation: null,
})

const register = () => form.post(route('register.store'))

</script>