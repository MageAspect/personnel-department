<template>
    <div class="pb-5 px-6 border-b border-oceanic-light">
        <div class="flex justify-between">
            <div class="flex text-gray-light font-light text-xl items-center">
                <div class="text-gray-dark">
                    <slot name="icon"></slot>
                </div>
                <div class="ml-4 tracking-wider flex items-center">
                    <div class="mr-2">{{ title }}</div>
                    <input v-if="typeof titleInput === 'string'"
                           type="text"
                           class="text-xl leading-5 bg-unset border border-blue-dark pt-1 px-1.25 pb-1.25 font-light"
                           :value="titleInput"
                           @input="$emit('update:titleInput', $event.target.value)">
                </div>
            </div>
            <div class="flex">
                <slot name="buttons"></slot>
            </div>
        </div>
        <slot name="input-error"></slot>
    </div>
</template>

<script>
export default {
    name: "page-header",
    props: ['titleInput', 'fontAwesomeClasses', 'title'],
    emits: ['update:titleInput'],
}
</script>
