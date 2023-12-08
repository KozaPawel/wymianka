<template>
    <input v-model="filters.towns" type="text" @input="search" />
</template>

<script setup>
import { ref, watch, reactive } from 'vue'
import axios from 'axios'
import { debounce } from 'lodash'

const searchedName = ref('')

const filters = reactive({
    towns: searchedName,
})

const towns = ref({})

const search = debounce(() => {
    if(searchedName.value.length >= 3) {
        axios.get(route('towns', filters))
            .then((response) => {
                towns.value = response.data
            })
    } else {
        towns.value = {}
    }
}, 500)

const emit = defineEmits(['towns'])

watch(
    towns, (value) => emit('towns', value),
)
</script>