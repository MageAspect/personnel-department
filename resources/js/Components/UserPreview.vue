<template>
    <div class="w-13 h-13 shrink-0 rounded-50% overflow-hidden">
        <div class="w-inherit h-inherit bg-no-repeat bg-center bg-cover"
             :style="avatarStyles"></div>
    </div>

    <div class="ml-4 font-medium">
        <a :href=profileLink class="mb-1 link-gray-light text-base">{{ fullName }}</a>
        <div class="text-gray text-xs">{{ position }}</div>
    </div>

    <div class="font-medium ml-18">
        <div class="mb-1 text-gray-lighter text-sm">Телефон:</div>
        <div class="mb-1 text-gray-lighter text-sm">Email:</div>
    </div>

    <div class="font-medium ml-18">
        <div class="mb-1 text-gray-lighter text-sm">{{ phone }}</div>
        <div class="mb-1 text-gray-lighter text-sm">{{ email }}</div>
    </div>
</template>

<script>
export default {
    name: "user-preview",
    props: {
        name: String,
        lastName: String,
        profileLink: String,
        avatarPath: String,
        position: String,
        email: String,
        phone: String,
    },
    computed: {
        avatarStyles: function () {
            return {
                backgroundImage: `url('${this.avatarPath}')`
            };
        },
        fullName: function () {
            return `${this.lastName} ${this.name}`;
        },
    }
}
</script>
