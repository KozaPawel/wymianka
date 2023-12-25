<template>
    <div class="w-full md:w-96">
        <Combobox v-model="selectedTown">
            <div class="relative">
                <div
                    class="relative w-full cursor-default overflow-hidden rounded-lg bg-light-accent text-left shadow-sm sm:text-sm combobox-focus border border-gray-300"
                >
                    <ComboboxInput
                        :display-value="(town) => `${town.name ? town.name + ',' : ''}${town.county ? ' ' + town.county + ',': ''} ${town.province ? town.province : ''}`.trim()"
                        class="input w-full border-none py-2 pl-3 pr-10 text-md leading-5"
                        autocomplete="off"
                        :placeholder="props.placeholder ? props.placeholder : 'Wyszukaj miejscowość'"
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
                        class="absolute mt-1 max-h-60 w-full overflow-auto rounded-md bg-light-background py-1 text-base shadow-lg ring-1 ring-black/5 focus:outline-none sm:text-sm"
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
                            class="hover:cursor-pointer border-b-2 border-gray-200"
                            @click="handleSelectedItem(town)"
                        >
                            <li
                                class="relative cursor-default select-none py-2 px-4 text-gray-900"
                                :class="{
                                    'bg-[#61ae3f]': active,
                                    'border-none': towns[towns.length - 1] === town
                                }"
                            >
                                <span
                                    class="break-words font-medium"
                                >
                                    {{ town.name }},
                                    {{ town.county ? 'powiat ' + town.county + ',': '' }}
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
import { usePage } from '@inertiajs/vue3'
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

const page = usePage()

const props = defineProps({
    placeholder: String,
})

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