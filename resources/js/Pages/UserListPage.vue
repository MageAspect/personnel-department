<template>
    <page-header title="Список пользователей">
        <template v-slot:icon>
            <i class="fas fa-user-friends"></i>
        </template>
        <template v-slot:buttons>
            <a v-if="canStore" href="/users/create" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                <span>Добавить</span>
            </a>
        </template>
    </page-header>

    <page-body>
        <user-list></user-list>
    </page-body>
</template>

<script>
import PageBody from "../Components/PageBody.vue";
import UserList from "../Components/User/UserList.vue";
import Error from "../Components/Department/Error.vue";
import PageHeader from "../Components/PageHeader.vue";

export default {
    name: "UserListPage",
    components: {PageHeader, Error, UserList, PageBody},
    props: {
        canStore: Boolean
    }
}
</script>
