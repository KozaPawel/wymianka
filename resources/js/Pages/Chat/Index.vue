<template>
    <div class="grid grid-cols-12 gap-2">
        <div class="col-span-12 md:col-span-2">
            <div v-for="room in props.rooms" :key="room.id" class="flex flex-col items-start justify-center ">
                <button class="w-full h-full" @click="changeRoom(room)">
                    <div class="btn-accent flex mb-2" :class="{'bg-light-primary text-light-background-200 hover:text-black': room.id === chat.currentRoom.id}">
                        <text>{{ room.conversation_with }}</text>
                    </div>
                </button>
            </div>
        </div>
        <div class="col-span-12 md:col-span-10">
            <div v-if="chat.currentRoom.length === 0" class="flex items-center justify-center text-medium text-xl">
                Nie wybrano czatu
            </div>

            <div v-else>
                <Messages :messages="chat.messages" />
                <MessageInput :room="chat.currentRoom" />
            </div>
        </div>
    </div>
</template>

<script setup>
import axios from 'axios'
import { reactive, onMounted, watch } from 'vue'
import Messages from '@/Components/Messages.vue'
import MessageInput from '@/Components/MessageInput.vue'

const connect = () => {
    if(chat.currentRoom) {
        getMessages()
        window.Echo.private('chat.' + chat.currentRoom.id)
            .listen('MessageSent', (e) => {
                getMessages()
            })
    }
}

const disconnect = (room) => {
    if(chat.currentRoom) {
        window.Echo.leave('chat.' + room)
    }
}

const props = defineProps({
    rooms: Object,
    currentRoom: Object,
})

const chat = reactive({
    currentRoom: props.currentRoom,
    messages: [],
})

const changeRoom = (room) => {
    chat.currentRoom = room
}

const getMessages = () => {
    axios.get('/chat/room/' + chat.currentRoom.id + '/messages')
        .then(response => {
            chat.messages = response.data
        })
        .catch(error => {
            console.log(error)
        })
}

onMounted(() => {
    if(chat.currentRoom.length !== 0) {
        changeRoom(props.currentRoom[0])
        connect()
    }
    watch(() => chat.currentRoom.id, (newValue, oldValue) => {
        if( oldValue ) {
            disconnect(oldValue)
        }
        connect()
    })
})
</script>