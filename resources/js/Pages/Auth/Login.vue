<template>
    <form @submit.prevent="login">
        <div class="w-1/2 mx-auto">
            <div>
                <label class="label" for="email">E-mail</label>
                <input id="email" v-model="form.email" type="email" class="input" required />
            </div>
            <div class="mt-4">
                <label class="label" for="password">Hasło</label>
                <input id="password" v-model="form.password" type="password" class="input" required />
                <ErrorMessage v-if="form.errors.loginError" :error="form.errors.loginError" />
            </div>
            <div class="mt-6">
                <button class="btn-primary w-full md:w-1/3" type="submit">Zaloguj się</button>
            </div>
            <div class="mt-3 text-center md:text-left text-sm">
                <Link :href="route('register')">
                    Nie masz jeszcze konta? 
                    <span class="font-bold">Zarejestruj się</span>
                </Link>
            </div>
        </div>
    </form>
</template>

<script setup>
import { useForm, Link } from '@inertiajs/vue3'
import ErrorMessage from '@/Components/ErrorMessage.vue'

const form = useForm({
    email: null,
    password: null,
})

const login = () => form.post(route('login.store'))

</script>