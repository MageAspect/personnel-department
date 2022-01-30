<template>
    <page-header :title="department.name">
        <template v-slot:icon>
            <i class="fas fa-layer-group"></i>
        </template>
        <template v-slot:buttons>
            <a :href="listUrl" class="btn btn-light mr-4">
                <span>К списку</span>
            </a>
            <a :href="editUrl" class="btn btn-primary">
                <span>Редактировать</span>
            </a>
        </template>
    </page-header>
    <page-body>
        <div class="bg-oceanic-light p-6">
            <div class="flex mb-6">
                <div class="tracking-wider text-gray-light text-xl mr-3">Руководитель отдела</div>
            </div>
            <div class="pb-6 border-b border-oceanic-lighter">
                <user-preview :user="department.head"
                ></user-preview>
            </div>
        </div>
        <div class="bg-oceanic-light p-6 mt-6">
            <div class="tracking-wider flex items-center text-gray-light text-xl mb-6">Описание</div>
            <div class="text-gray w-full">
                {{ department.description }}
            </div>
        </div>

        <div class="bg-oceanic-light p-6 pb-0 mt-6">
            <div class="flex">
                <div class="mr-2 tracking-wider text-gray-light text-xl">Сотрудники ({{
                        department.members.length
                    }})
                </div>
            </div>
            <div class="grid grid-col-users-list gap-y-6 py-6">
                <user-preview-in-grid v-for="m of department.members" :user="m"
                ></user-preview-in-grid>
            </div>
        </div>
    </page-body>
</template>

<script>
import UserPreviewInGrid from "../User/UserPreviewInGrid.vue";
import Error from "./Error.vue";
import UserPreview from "../User/UserPreview.vue";
import PageHeader from "../PageHeader.vue";
import {User} from "../User/User.js";
import {Department} from "./Department.js";
import PageBody from "../PageBody.vue";

export default {
    name: "DepartmentShow",
    components: {PageBody, PageHeader, UserPreview, Error, UserPreviewInGrid},

    props: {
        jsonDepartment: JSON,
        editUrl: String,
        listUrl: String,
    },

    data() {
        return {
            department: {
                id: 0,
                name: '',
                description: '',
                head: new User(),
                members: []
            }
        }
    },

    created() {
        console.log(this.jsonDepartment)
        this.department = Department.fromJson(this.jsonDepartment);
    }
}
</script>
