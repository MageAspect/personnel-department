<template>
    <div class="flex">
        <user-preview-body :user="user"
        ></user-preview-body>
    </div>
</template>

<script>
import UserPreviewBody from "./UserPreviewBody.vue";
import {User} from "./User.js";

export default {
    name: "user-preview",
    components: {UserPreviewBody},

    props: {
        user: User,
    }
}
</script>
