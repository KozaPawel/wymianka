<template>
    <div class="h-[30rem] 2xl:h-[40rem]">
        <div class="h-full p-2 flex flex-col-reverse overflow-y-auto">
            <div v-for="message in props.messages" :key="message.id" class="flex justify-start w-full" :class="{'justify-end': user.id === message.sender_id}">
                <div class="flex justify-start w-1/2 break-all" :class="{'justify-end': user.id === message.sender_id}">
                    <div class="bg-light-hover-gray p-2 mb-1 rounded-xl w-fit" :class="{'justify-end bg-light-primary text-light-background-200': user.id === message.sender_id}">
                        {{ message.message }}
                    
                        <div class="flex justify-start text-xs" :class="{'justify-end': user.id === message.sender_id}">
                            {{ isDateToday(message.created_at) ? message.created_at.slice(11, 16) : '' }}
                            <FormattedDate v-if="!isDateToday(message.created_at)" :date="message.created_at" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import FormattedDate from './UI/FormattedDate.vue'
const page = usePage()

const user = computed(
    () => page.props.user,
)
const props = defineProps({
    messages: Array,
})

const today = new Date()

const isDateToday = (date) => {
    const messageDate = new Date(date)

    messageDate.setHours(0,0,0,0)
    today.setHours(0,0,0,0)

    return messageDate.getTime() === today.getTime()
}
</script>