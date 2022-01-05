<template>
    <teleport to="body">
        <div class="absolute top-0 left-0 bg-popup w-full-screen h-full-screen">
            <div class="w-full h-full flex items-center justify-center">
                <div class="bg-oceanic-light w-fit py-10 px-8 relative">
                    <div class="absolute -top-12 -right-8"><i @click="closePopupTrigger()"
                                                              class="cursor-pointer text-2xl text-gray-light  fa-solid fa-xmark"></i>
                    </div>
                    <div class="grid grid-col-users-list gap-y-6 ui-y-scroll max-h-96 px-2">
                        <user-preview-in-grid v-for="user in searchedUsers" :user="user"
                                              action-button-text="Выбрать"
                                              action-button-class="btn-light-add"
                                              @select-user="userSelected"
                        ></user-preview-in-grid>
                    </div>
                </div>
            </div>
        </div>
    </teleport>
</template>

<script>
import UserPreviewInGrid from "./UserPreviewInGrid.vue";
import {User} from "./User.js";

export default {
    name: "user-selector-popup",
    components: {UserPreviewInGrid},
    emits: ['selectUser'],

    props: {
        closePopupTrigger: Function
    },

    data() {
        return {
            searchedUsers: []
        };
    },

    methods: {
        closeEvent(e) {
            if (e.keyCode !== 27) {
                return;
            }

            this.closePopupTrigger();
        },

        userSelected(user) {
            this.$emit('selectUser', user);
            this.closePopupTrigger()
        }
    },

    created: function () {
        window.addEventListener('keydown', this.closePopupTrigger);

        let user = new User();
        user.id = 15;
        user.name = 'Андрей';
        user.lastName = 'Башкиров';
        user.email = 'mark@mosowell.ru';
        user.phone = '8 (961) 689 28-48';
        user.position = 'Генеральный директор';
        user.avatarPath = '/img/user/user.jpg';
        user.profileLink = '/123/';
        this.searchedUsers.push(user);
    },
    destroyed: function () {
        window.removeEventListener('keydown', this.closePopupTrigger);
    }
}
</script>

