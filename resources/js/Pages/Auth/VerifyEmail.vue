<template>
    <div>
        <p class="text-xl font-medium">
            Aby wyświetlić zawartość, musisz zweryfikować swoje konto poprzez potwierdzenie maila
        </p>
        <p class="text-lg">
            Brak wiadomości email? Sprawdź folder spam lub
            <Link 
                :href="route('verification.send')" 
                method="post"
                as="button"
                class="underline text-blue-600"
            >
                Wyślij ponownie link aktywacyjny
            </Link>
        </p>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
</script>