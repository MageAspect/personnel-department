<template>
  <div>
      <div v-for="message of errors" :class="['mb-6', 'text-red', 'text-sm']">{{ message }}</div>
  </div>
</template>

<script>
export default {
    name: "MultipleError",

    props: {
        errors: []
    }
}
</script>

