<template>
    <div class="mt-6 text-red text-sm">{{ message }}</div>
</template>

<script>
export default {
    name: "Error",
    props: {
        message: String
    }
}
</script>
