<template>
    <div class="w-13 h-13 shrink-0 rounded-50% overflow-hidden">
        <div class="w-inherit h-inherit bg-no-repeat bg-center bg-cover"
             :style="avatarStyles"></div>
    </div>

    <div class="ml-4 font-medium">
        <a :href="user.profileLink" class="mb-1 link-gray-light text-base">{{ fullName }}</a>
        <div class="text-gray text-xs">{{ user.position }}</div>
    </div>

    <div class="font-medium ml-18">
        <div class="mb-1 text-gray-lighter text-sm">Телефон:</div>
        <div class="mb-1 text-gray-lighter text-sm">Email:</div>
    </div>

    <div class="font-medium ml-18">
        <div class="mb-1 text-gray-lighter text-sm">{{ user.phone }}</div>
        <div class="mb-1 text-gray-lighter text-sm">{{ user.email }}</div>
    </div>
</template>

<script>
import {User} from "./User.js";

export default {
    name: "user-preview-body",
    props: {
        user: User,
    },
    computed: {
        avatarStyles: function () {
            return {
                backgroundImage: `url('${this.user.avatarPath}')`
            };
        },
        fullName: function () {
            return `${this.user.lastName} ${this.user.name}`;
        },
    }
}
</script>
