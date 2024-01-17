<template>
    <div class="grid grid-cols-12 gap-2 lg:h-[33rem] 2xl:h-[43rem] ">
        <button class="col-span-12 flex flex-row items-center w-full h-full gap-2 lg:hidden" :class="{'hidden lg:block': !chatOpen}" @click="closeChat">
            <ArrowLeftIcon class="w-6 h-6" />
            <text class="font-medium text-md">Kontakty</text>
        </button>
        <Box class="col-span-12 lg:col-span-2 h-full overflow-y-scroll" :class="{'hidden lg:block': chatOpen}">
            <div v-if="props.rooms.length !== 0">
                <div class="font-semibold text-xl mb-4">
                    Kontakty
                </div>
                
                <div v-for="room in props.rooms" :key="room.id" class="flex flex-col items-start justify-center">
                    <button class="w-full h-full" @click="changeRoom(room)">
                        <div class="btn-accent flex flex-col mb-2 items-start" :class="{'lg:bg-light-primary lg:text-light-background-200 hover:text-black': room.id === chat.currentRoom.id}">
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
        
        <Box class="col-span-12 lg:col-span-10 w-full h-full p-0" :class="{'hidden lg:block': !chatOpen}">
            <div v-if="chat.currentRoom.length === 0" class="flex items-center justify-center text-medium text-xl" :class="{'p-4': props.rooms.length !== 0}">
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
import { reactive, onMounted, watch, ref } from 'vue'
import { ChatBubbleBottomCenterTextIcon, ArrowLeftIcon } from '@heroicons/vue/20/solid'
import Messages from '@/Components/Messages.vue'
import MessageInput from '@/Components/MessageInput.vue'
import Box from '@/Components/UI/Box.vue'

const chatOpen = ref(false)

const closeChat = () => {
    disconnect(chat.currentRoom.id)
    chatOpen.value = false
}

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
    chatOpen.value = true
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