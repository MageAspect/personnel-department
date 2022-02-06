<template>
    <div class="p-6 mb-6 bg-oceanic-light">
        <template v-if="title">
            <div class="text-gray-light text-lg ">{{ title }}</div>
            <div class="mt-5">
                <slot></slot>
            </div>
        </template>
        <slot v-else></slot>
    </div>
</template>

<script>
export default {
    name: "ProfileBlock",
    props: {
        title: String
    }
}
</script>

