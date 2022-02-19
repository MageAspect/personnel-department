<template>
    <div v-if="value || editMode">
        <div class="font-light text-xs text-gray">{{ name }}:</div>
        <input v-if="editMode"
               autocomplete="new-password"
               class="autofill-remove text-base p-2 mt-2.5 border border-blue-dark transition
                      font-light bg-unset text-gray-light focus:border-green"
               :type="type"
               v-maska="maska"
               :value="value"
               @input="$emit('update:value', $event.target.value)"/>
        <div v-else class="text-base mt-1 font-light text-gray-light ">{{ (value ? value : '') }}</div>
    </div>
</template>

<style scoped>
.autofill-remove:-webkit-autofill,
.autofill-remove:-webkit-autofill:hover,
.autofill-remove:-webkit-autofill:focus,
.autofill-remove:-webkit-autofill:active {
    -webkit-box-shadow: unset !important;
}
</style>

<script>

import {maska} from 'maska'

export default {
    name: "NamedField",
    emits: ['update:value'],
    directives: {maska},
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

        maska: {
            type: String,
            default: null,
        },

        editMode: {
            type: Boolean,
            default: false
        }
    }
}
</script>


