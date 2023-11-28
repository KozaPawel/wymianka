<template>
    <div class="border border-gray-200 bg-light-background-200 rounded-md p-4 shadow-sm">
        <div class="text-gray-500 font-medium">
            <slot name="header" />
        </div>
        <slot />
    </div>
</template>
