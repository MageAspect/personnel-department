<template>
    <full-screen-popup :close-popup-trigger="closePopupTrigger" :initialized="initialized">
        <search @search-input="onSearchInput" v-model="search" class="mb-6 w-2/4"
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
    </full-screen-popup>
</template>

<script>
import UserPreviewInGrid from "./UserPreviewInGrid.vue";
import {User} from "./User.js";
import Search from "../search.vue";
import FullScreenPopup from "../UI/Popup/FullScreenPopup.vue";

export default {
    name: "user-selector-popup",
    components: {FullScreenPopup, Search, UserPreviewInGrid},
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

        onSearchInput(search) {
            clearTimeout(this.searchInputTimeout);
            this.searchInputTimeout = setTimeout(
                () => {this.searchUsers(search)},
                500
            )
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

