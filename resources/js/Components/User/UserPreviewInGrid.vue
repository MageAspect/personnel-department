<template>
    <user-preview-body :user="user"
    ></user-preview-body>
    <div class="pl-3 pt-1">
        <div @click="$emit('selectUser', user)" :class="[actionButtonClass, 'btn']">{{ actionButtonText }}</div>
    </div>
    <div></div>
    <div class="grid-rows-delimiter"></div>
</template>

<script>
import UserPreviewBody from "./UserPreviewBody.vue";
import {User} from "./User.js";

export default {
    name: "user-preview-in-grid",
    components: {UserPreviewBody},

    props: {
        id: Number,
        user: User,
        actionButtonText: String,
        actionButtonClass: String,
    },

    emits: ['selectUser']
}
</script>

