<template>
    <div class="contents">
        <user-preview :name="name"
                      :lastName="lastName"
                      :position="position"
                      :email="email"
                      :phone="phone"
                      :profileLink="profileLink"
                      :avatarPath="avatarPath"
        ></user-preview>
        <div class="pl-3 pt-1">
            <div @click="$emit('selectUser', id)" :class="[actionButtonClass, 'btn']">{{ actionButtonText }}</div>
        </div>
        <div></div>
    </div>
    <div class="grid-rows-delimiter"></div>
</template>

<script>
import UserPreview from "./UserPreview.vue";

export default {
    name: "user-preview-in-grid",
    components: {UserPreview},

    props: {
        id: Number,
        name: String,
        lastName: String,
        position: String,
        email: String,
        phone: String,
        profileLink: String,
        avatarPath: String,
        actionButtonText: String,
        actionButtonClass: String,
    },
}
</script>

