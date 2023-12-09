<template>
    <div class="w-96">
        <Combobox v-model="selectedTown">
            <div class="relative">
                <div
                    class="relative w-full cursor-default overflow-hidden rounded-lg bg-white text-left shadow-md focus:outline-none focus-visible:ring-2 focus-visible:ring-white/75 focus-visible:ring-offset-2 focus-visible:ring-offset-teal-300 sm:text-sm"
                >
                    <ComboboxInput
                        :display-value="(town) => `${town.name ? town.name + ',' : ''} ${town.county ? town.county + ',': ''} ${town.province ? town.province : ''}`.trim()"
                        class="w-full border-none py-2 pl-3 pr-10 text-sm leading-5 text-gray-900 focus:ring-0 "
                        autocomplete="off"
                        placeholder="Wyszukaj miasto"
                        @change="handleInputChange"
                    />

                    <ComboboxButton
                        class="absolute inset-y-0 right-0 flex items-center pr-2"
                    >
                        <XMarkIcon 
                            v-if="towns.length"
                            class="h-5 w-5 text-gray-400"
                            aria-hidden="true"
                            @click="clearSearch"
                        />

                        <ChevronUpDownIcon
                            v-else
                            class="h-5 w-5 text-gray-400"
                            aria-hidden="true"
                        />
                    </ComboboxButton>
                </div>
                <TransitionRoot
                    leave="transition ease-in duration-100"
                    leave-from="opacity-100"
                    leave-to="opacity-0"
                    @after-leave="query = ''"
                >
                    <ComboboxOptions
                        class="absolute mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black/5 focus:outline-none sm:text-sm"
                    >
                        <div
                            v-if="towns.length === 0 && filters.towns !== ''"
                            class="relative cursor-default select-none px-4 py-2 text-gray-700"
                        >
                            Nie znaleziono
                        </div>

                        <ComboboxOption
                            v-for="town in towns"
                            :key="town.id"
                            v-slot="{ selectedTown, active }"
                            as="template"
                            :value="town"
                            class="hover:cursor-pointer"
                            @click="handleSelectedItem(town)"
                        >
                            <li
                                class="relative cursor-default select-none py-2 pl-10 pr-4 text-gray-900"
                                :class="{
                                    'bg-[#61ae3f]': active,
                                }"
                            >
                                <span
                                    class="break-words font-medium"
                                >
                                    {{ town.name }},
                                    powiat {{ town.county }},
                                    województwo {{ town.province }}
                                </span>
                            </li>
                        </ComboboxOption>
                    </ComboboxOptions>
                </TransitionRoot>
            </div>
        </Combobox>
    </div>
</template>

<script setup>
import { ref, watch, reactive } from 'vue'
import axios from 'axios'
import { debounce } from 'lodash'
import {
    Combobox,
    ComboboxInput,
    ComboboxButton,
    ComboboxOptions,
    ComboboxOption,
    TransitionRoot,
} from '@headlessui/vue'
import { ChevronUpDownIcon, XMarkIcon } from '@heroicons/vue/20/solid'

const filters = reactive({
    towns: ref(''),
})

const towns = ref({})

const selectedTown = ref({})

const handleSelectedItem = (value) => {
    selectedTown.value = value
}

const clearSearch = () => {
    selectedTown.value = ''
    towns.value = {}
    filters.towns = ''
}

const search = debounce(() => {
    axios.get(route('towns', filters))
        .then((response) => {
            towns.value = response.data
        })
}, 500)

const handleInputChange = (event) => {
    filters.towns = event.target.value
    if(filters.towns.length >= 3) {
        search()
    } else {
        towns.value = ''
    }
}

const emit = defineEmits(['selectedTown'])

watch(
    selectedTown, (value) => emit('selectedTown', value),
)
</script>