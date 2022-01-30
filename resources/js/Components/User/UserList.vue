<template>
    <search @search="onSearch" class="w-96 mb-8" placeholder="Найти пользователей"></search>
    <div class="vld-parent w-fit">
        <loading v-model:active="isListLoading"
                 :is-full-page="false"
                 loader="spinner"
                 color="#1976d2"
                 background-color="rgba(0, 0, 0, 0.07)"
                 :width="users.length < 2 ? 20 : 50"
                 blur="0"
        />
        <div class="user-list-grid grid gap-y-6 w-fit">
            <grid-header-call></grid-header-call>
            <grid-header-call>id</grid-header-call>
            <grid-header-call>Фамилия</grid-header-call>
            <grid-header-call>Имя</grid-header-call>
            <grid-header-call>Отчество</grid-header-call>
            <grid-header-call>email</grid-header-call>
            <grid-header-call>Должность</grid-header-call>
            <grid-header-call>Телефон</grid-header-call>

            <template v-for="user of users">
                <hamburger-selector :items="[
                    {
                        text: 'Просмотреть',
                        link: `/users/${user.id}/`,
                        classes: ['hover:text-gray-light']
                    },
                    {
                        text: 'Изменить',
                        link: `/users/${user.id}/edit`,
                        classes: ['hover:text-green']
                    },
                    {
                        text: 'Удалить',
                        link: `/users/`,
                        classes: ['hover:text-red']
                    }
                ]"/>
                <grid-row-cell>{{ user.id }}</grid-row-cell>
                <grid-row-cell>{{ user.lastName }}</grid-row-cell>
                <grid-row-cell>{{ user.name }}</grid-row-cell>
                <grid-row-cell>{{ user.patronymic }}</grid-row-cell>
                <grid-row-cell>{{ user.email }}</grid-row-cell>
                <grid-row-cell>{{ user.position }}</grid-row-cell>
                <grid-row-cell>{{ user.phone }}</grid-row-cell>
            </template>
        </div>
    </div>
</template>

<style scoped>
.user-list-grid {
    grid-template-columns: min-content min-content min-content min-content
        min-content min-content max-content max-content;
}

.fade-enter-active, .fade-leave-active {
    transition: opacity 0.3s;
}

.fade-enter-from, .fade-leave-to {
    opacity: 0;
}
</style>

<script>
import HamburgerSelector from "../UI/Selector/HamburgerSelector.vue";
import Search from "../search.vue";
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import {User} from "./User.js";
import GridRowCell from "./Parts/GridRowCell.vue";
import GridHeaderCall from "./Parts/GridHeaderCell.vue";

export default {
    name: "UserList",
    components: {GridHeaderCall, GridRowCell, Search, HamburgerSelector, Loading},

    data() {
        return {
            isListLoading: true,

            search: '',
            sort: {},
            users: []
        }
    },

    methods: {
        onSearch(search) {
            this.search = search;

            this.loadUsers();
        },

        onSort() {


            clearTimeout(this.applySortTimeout);
            this.applySortTimeout = setTimeout(
                () => {
                    this.loadUsers()
                },
                500
            )
        },

        onPaginate() {

        },

        async loadUsers() {
            this.isListLoading = true;
            this.users = await this.getUsers(
                this.search,
                this.sort,
                0,
                10
            );
            this.isListLoading = false;
        },

        async getUsers(search = '', sort = [], offset = 0, limit = 10) {
            let response = await axios.post(
                '/users/find',
                {
                    search,
                    sort,
                    offset,
                    limit
                }
            );

            let users = [];

            for (let user of Object.values(response.data)) {
                users.push(User.fromJson(user));
            }

            return users;
        }
    },

    mounted() {
        this.loadUsers();
    }
}
</script>

