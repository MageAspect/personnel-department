<template>
        <div class="absolute top-0 left-0 bg-popup w-full-screen h-full-screen">
            <div class="w-full h-full flex items-center justify-center">
                <div v-if="initialized" class="bg-oceanic-light w-fit pt-10 pb-8 px-8 min-w-182.25 relative">
                    <div class="absolute -top-12 -right-8"><i @click="closePopupTrigger()"
                                                              class="cursor-pointer text-2xl text-gray-light  fa-solid fa-xmark"></i>
                    </div>
                    <search @search="searchUsers" v-model="search" class="mb-6 w-2/4"
                            placeholder="Найти сотрудника..."></search>
                    <div v-if="this.searchedUsers.length > 0"
                         class="grid grid-col-users-list gap-y-6 ui-y-scroll min-h-19.25 max-h-96 px-2">
                            <user-preview-in-grid v-for="user in searchedUsers" :user="user" :key="user.id"
                                                  action-button-text="Выбрать"
                                                  action-button-class="btn-light-add"
                                                  @select-user="userSelected"
                            ></user-preview-in-grid>
                    </div>
                    <div v-else class="text-gray">Подходящие пользователи не найдены.</div>
                </div>
            </div>
        </div>
</template>

<script>
import UserPreviewInGrid from "./UserPreviewInGrid.vue";
import {User} from "./User.js";
import Search from "../search.vue";

export default {
    name: "user-selector-popup",
    components: {Search, UserPreviewInGrid},
    emits: ['selectUser'],

    props: {
        closePopupTrigger: Function,
        findUsersUrl: String,
        excludedIds: Array
    },

    data() {
        return {
            initialized: false,
            search: '',
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

        userSelected(selectedUser) {
            this.$emit('selectUser', selectedUser);
            this.searchedUsers = this.searchedUsers.filter(user => user.id !== selectedUser.id)
        },

        /**
         * @param {String} search
         */
        searchUsers(search) {
            axios.get(
                this.findUsersUrl,
                {
                    params: {
                        search,
                        excludedIds: this.excludedIds
                    }
                }
            ).then(response => {
                let searched = [];
                for (let u of Object.values(response.data)) {
                    searched.push(User.fromJson(u));
                }

                this.searchedUsers = searched;
                this.initialized = true;
            });
        }
    },

    created: function () {
        document.body.style.overflow = 'hidden';

        window.addEventListener('keydown', this.closeEvent);

        this.searchUsers('');
    },
    destroyed: function () {
        document.body.style.removeProperty('overflow');

        window.removeEventListener('keydown', this.closePopupTrigger);
    }
}
</script>

