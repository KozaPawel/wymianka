<template>
    <Listbox v-model="selectedCategory">
        <div class="relative mt-1 w-full md:w-96">
            <ListboxButton
                class="input relative w-full hover:cursor-pointer text-left shadow-md "
            >
                <span class="block truncate" :class="{'text-gray-600': !selectedCategory}">{{ selectedCategory ? selectedCategory.name : "Wybierz kategorię" }}</span>
                <span
                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2"
                >
                    <ChevronUpDownIcon
                        class="h-5 w-5 text-gray-400"
                        aria-hidden="true"
                    />
                </span>
            </ListboxButton>

            <transition
                leave-active-class="transition duration-100 ease-in"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <ListboxOptions
                    class="absolute mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black/5 focus:outline-none sm:text-sm"
                >
                    <ListboxOption
                        v-for="category in props.categories"
                        v-slot="{ active, selected }"
                        :key="category.name"
                        :value="category"
                        as="template"
                    >
                        <li
                            class="hover:cursor-pointer"
                            :class="[
                                active ? 'bg-[#61ae3f] text-light-background-200' : 'text-gray-900',
                                'relative cursor-default select-none py-2 pl-10 pr-4',
                            ]"
                        >
                            <span
                                :class="[
                                    selected ? 'font-medium' : 'font-normal',
                                    'block truncate',
                                ]"
                            >{{ category.name }}</span>
                        </li>
                    </ListboxOption>
                </ListboxOptions>
            </transition>
        </div>
    </Listbox>
</template>

<script setup>
import { ref, watch } from 'vue'
import {
    Listbox,
    ListboxButton,
    ListboxOptions,
    ListboxOption,
} from '@headlessui/vue'
import { ChevronUpDownIcon } from '@heroicons/vue/20/solid'

const props = defineProps({
    categories: Object,
})

const selectedCategory = ref('')

const emit = defineEmits(['selectedCategory'])

watch(
    selectedCategory, (value) => emit('selectedCategory', value),
)
</script>