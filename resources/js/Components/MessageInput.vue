<template>
    <div class="h-10 m-1">
        <div class="grid md:grid-cols-6 gap-2 md:gap-10">
            <input v-model="form.message" type="text" placeholder="Treść wiadomości" class="input col-span-6 md:col-span-5 outline-none p-1" @keyup.enter="sendMessage()" />
            <button class="col-span-6 md:col-span-1 btn-accept" @click="sendMessage()">
                Wyślij
            </button>
        </div>
    </div>
</template>

<script setup>
import axios from 'axios'
import { useForm } from '@inertiajs/vue3'

const props = defineProps({
    room: Object,
})

const form = useForm({
    message: '',
})

const sendMessage = () => {
    if(form.message.length == ' ' ) {
        return
    }
    axios.post('/chat/room/' + props.room.id + '/message', {
        message: form.message,
    })
        .then( response => {
            if(response.status == 201) {
                form.message = ''
            }
        })
        .catch( error => {
            console.log(error)
        })
}
</script>