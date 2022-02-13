<template>
    <div>
        <div class="font-light text-xs text-gray-light">{{ name }}:</div>
        <input v-if="editMode" class="text-base p-2 mt-2.5 border border-blue-dark transition
                      font-light bg-unset text-gray-light focus:border-green"
               :type="type"
               :value="value"
               @input="$emit('update:value', $event.target.value)"/>
        <div v-else>{{ value }}</div>
    </div>
</template>

<script>
export default {
    name: "NamedField",
    emits: ['update:value'],
    props: {
        name: {
            type: String,
            required: true
        },
        value: {
            type: String,
            required: true
        },

        type: {
            type: String,
            default: 'text',
        },

        editMode: {
            type: Boolean,
            default: false
        }
    }
}
</script>


