<template>
    <search @search-input="onSearch" class="w-96 mb-8" placeholder="Найти пользователей"></search>
    <div class=" w-fit">
        <div class="user-list-grid grid gap-y-6 w-fit vld-parent">
            <loading v-model:active="isUsersLoading"
                     :is-full-page="false"
                     loader="spinner"
                     color="#1976d2"
                     background-color="rgba(0, 0, 0, 0.07)"
                     :width="users.length < 2 ? 20 : 50"
                     blur="0"
            />

            <grid-header-cell/>
            <grid-header-cell sort-column-name="id"
                              sort-column-text="id"
                              v-model:sort-direction="sort.id"
                              @sort="onSort"
            />
            <grid-header-cell sort-column-name="lastName"
                              sort-column-text="Фамилия"
                              v-model:sort-direction="sort.lastName"
                              @sort="onSort"
            />
            <grid-header-cell sort-column-name="name"
                              sort-column-text="Имя"
                              v-model:sort-direction="sort.name"
                              @sort="onSort"
            />
            <grid-header-cell sort-column-name="patronymic"
                              sort-column-text="Отчество"
                              v-model:sort-direction="sort.patronymic"
                              @sort="onSort"
            />
            <grid-header-cell sort-column-name="email"
                              sort-column-text="email"
                              v-model:sort-direction="sort.email"
                              @sort="onSort"
            />
            <grid-header-cell sort-column-name="position"
                              sort-column-text="Должность"
                              v-model:sort-direction="sort.position"
                              @sort="onSort"
            />
            <grid-header-cell sort-column-text="Телефон"/>

            <template v-for="user of users">
                <hamburger-selector :items="[
                    {
                        text: 'Просмотреть',
                        link: `/users/${user.id}/`,
                        classes: ['hover:text-gray-light']
                    },
                    user.canBeUpdated ? {
                        text: 'Редактировать',
                        link: `/users/${user.id}/edit`,
                        classes: ['hover:text-green']
                    } : null,
                    user.canBeDeleted ? {
                        text: 'Удалить',
                        clickHandler: this.deleteUser.bind(this, user.id),
                        classes: ['hover:text-red']
                    } : null
                ].filter(item => item !== null)"/>
                <grid-row-cell>{{ user.id }}</grid-row-cell>
                <grid-row-cell>{{ user.lastName }}</grid-row-cell>
                <grid-row-cell>{{ user.name }}</grid-row-cell>
                <grid-row-cell>{{ user.patronymic }}</grid-row-cell>
                <grid-row-cell>{{ user.email }}</grid-row-cell>
                <grid-row-cell>{{ user.position }}</grid-row-cell>
                <grid-row-cell>{{ user.phone }}</grid-row-cell>
            </template>
        </div>
        <transition name="fade">
            <grid-pagination v-if="initialLoadingInFinished"
                             :is-page-change-disabled="isUsersLoading"
                             :records-total-count="pagination.recordsTotalCount"
                             :records-per-page="pagination.recordsPerPage"
                             :current-page="pagination.currentPage"
                             @change-page="changePage"
            />
        </transition>
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
import GridHeaderCell from "./Parts/GridHeaderCell.vue";
import GridPagination from "../UI/Pagination/GridPagination.vue";

export default {
    name: "UserList",
    components: {GridPagination, GridHeaderCell, GridRowCell, Search, HamburgerSelector, Loading},

    data() {
        return {
            initialLoadingInFinished: false,

            isUsersLoading: true,
            loadUsersTimeout: null,

            useOnlyOneColumnToSort: true,

            search: '',
            sort: {id: 'desc'},
            users: [],

            findUserCanselToken: null,

            pagination: {
                recordsPerPage: 10,
                recordsTotalCount: 1,
                currentPage: 1
            }
        }
    },

    methods: {
        onSearch(search) {
            this.search = search;
            this.createLoadUsersRequest(600);
        },

        onSort(columnName, direction) {
            if (this.useOnlyOneColumnToSort) {
                this.sort = {};
            }
            this.sort[columnName] = direction;

            this.createLoadUsersRequest(600)
        },

        changePage(pageNumber) {
            this.pagination.currentPage = pageNumber;

            this.createLoadUsersRequest(0);
        },

        createLoadUsersRequest(milliseconds) {
            clearTimeout(this.loadUsersTimeout);
            this.loadUsersTimeout = setTimeout(
                () => {
                    this.loadUsers();
                },
                milliseconds
            );
        },

        async loadUsers() {
            this.isUsersLoading = true;

            let {users, total} = await this.getUsers(
                this.search,
                this.sort,
                this.pagination.recordsPerPage * (this.pagination.currentPage - 1),
                this.pagination.recordsPerPage
            );

            this.users = users;
            this.pagination.recordsTotalCount = total;

            this.isUsersLoading = false;
        },

        async getUsers(search = '', sort = [], offset = 0, limit = 10) {
            if (this.findUserCanselToken) {
                this.findUserCanselToken.cancel('New search users request');
            }
            this.findUserCanselToken = axios.CancelToken.source();

            let response;
            try {
                response = await axios.post(
                    '/users/find',
                    {
                        search,
                        sort,
                        offset,
                        limit
                    },
                    {
                        cancelToken: this.findUserCanselToken.token,
                    }
                );
            } catch (er) {
                if (er?.__CANCEL__ === true) {
                    return;
                }
                throw er;
            }

            let users = [];

            for (let user of Object.values(response.data)) {
                users.push(User.fromJson(user));
            }

            return {
                users,
                total: Number(response.headers['x-total-count'])
            };
        },

        deleteUser(id) {
            this.isUsersLoading = true;

            axios.delete(
                `/users/${id}`
            )
                .then(() => {
                    this.users = this.users.filter((user) => user.id !== id);
                })
                .catch(() => alert('Ошибка удаления пользователя'))
                .finally(() => this.isUsersLoading = false);
        }
    },

    mounted() {
        this.loadUsers()
            .finally(
                () => {this.initialLoadingInFinished = true}
            );
    }
}
</script>

