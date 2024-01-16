<template>
    <div class="grid grid-cols-12 gap-2 h-[33rem] 2xl:h-[43rem] ">
        <Box class="col-span-12 md:col-span-2 h-full overflow-y-scroll">            
            <div v-if="props.rooms.length !== 0">
                <text class="font-semibold text-xl">
                    Wiadomości
                </text>
                <div v-for="room in props.rooms" :key="room.id" class="flex flex-col items-start justify-center mt-4">
                    <button class="w-full h-full" @click="changeRoom(room)">
                        <div class="btn-accent flex mb-2" :class="{'bg-light-primary text-light-background-200 hover:text-black': room.id === chat.currentRoom.id}">
                            <text>{{ room.conversation_with }}</text>
                        </div>
                    </button>
                </div>
            </div>

            <div v-else class="flex flex-col items-center justify-center">
                <ChatBubbleBottomCenterTextIcon class="h-10 w-10" />
                <span class="text-xl font-bold">Brak kontaktów</span>
            </div>
        </Box>
        
        <Box class="col-span-12 md:col-span-10 p-0">
            <div v-if="chat.currentRoom.length === 0" class="flex items-center justify-center text-medium text-xl">
                {{ props.rooms.length !== 0 ? "Nie wybrano czatu" : "" }}
            </div>

            <div v-else>
                <Messages :messages="chat.messages" />
                <MessageInput :room="chat.currentRoom" />
            </div>
        </Box>
    </div>
</template>

<script setup>
import axios from 'axios'
import { reactive, onMounted, watch } from 'vue'
import { ChatBubbleBottomCenterTextIcon } from '@heroicons/vue/20/solid'
import Messages from '@/Components/Messages.vue'
import MessageInput from '@/Components/MessageInput.vue'
import Box from '@/Components/UI/Box.vue'

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