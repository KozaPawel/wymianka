<template>
    <h1 class="page-title">Powiadomienia</h1>

    <div v-if="props.notifications.data.length">
        <div v-for="notification in props.notifications.data" :key="notification.id" class="flex justify-between items-center border-b border-gray-200 py-4">
            <div v-if="notification.type === 'App\\Notifications\\OfferPlaced'">
                Otrzymano nową ofertę dla 
                <Link :href="route('listing.show', {listing: notification.data.listing.id})" class="hover:underline">
                    {{ notification.data.listing.name }}
                </Link>,
                oferowany przedmiot
                <Link :href="route('listing.show', {listing: notification.data.offer.id})" class="hover:underline">
                    {{ notification.data.offer.name }}
                </Link>
                od użytkownika
                <Link :href="route('user.show', {user: notification.data.trader.id})" class="hover:underline">
                    {{ notification.data.trader.name }}
                </Link>.
                <Link :href="route('user.listing.show', {listing: notification.data.listing.id})" class="hover:underline text-blue-600">
                    Zobacz oferty wymiany
                </Link>
            </div>

            <div>
                <Link
                    v-if="!notification.read_at" 
                    :href="route('notification.update', {notification: notification.id})" 
                    as="button" method="put" 
                    class="btn-accent"
                >
                    Oznacz jako przeczytane
                </Link>
            </div>
        </div>

        <div v-if="props.notifications.last_page !== 1" class="w-full flex justify-center mt-4 mb-4">
            <Pagination :links="props.notifications.links" :prev-page-url="props.notifications.prev_page_url" :next-page-url="props.notifications.next_page_url" />
        </div>
    </div>
    <div v-else class="flex flex-col items-center justify-center">
        <BellSlashIcon class="h-10 w-10" />
        <span class="text-xl font-bold">Brak nowych powiadomień</span>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { BellSlashIcon } from '@heroicons/vue/20/solid'
import Pagination from '@/Components/UI/Pagination.vue'

const props = defineProps({
    notifications: Object,
})
</script>