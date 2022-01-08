<template>
    <div :class="[{'mt-6': marginTop}, {'mb-6': marginBottom}, 'text-red', 'text-sm']">{{ message }}</div>
</template>

<script>
export default {
    name: "Error",
    props: {
        message: String,
        marginTop: Boolean,
        marginBottom: Boolean,
    }
}
</script>
