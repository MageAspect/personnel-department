<template>
    <page-header v-model:title-input="department.name" title="Редактирование:">
        <template v-slot:icon>
            <i class="fas fa-layer-group"></i>
        </template>
        <template v-slot:buttons>
            <a href="/" class="btn btn-light mr-4">
                <span>К списку</span>
            </a>
            <button @click.prevent="saveDepartment()" class="btn btn-success">
                <span>Сохранить</span>
            </button>
        </template>
    </page-header>
    <div class="p-6 pb-0">
        <div class="bg-oceanic-light p-6">
            <div class="flex mb-6">
                <div class="tracking-wider text-gray-light text-xl mr-3">Руководитель отдела</div>
                <div @click="openHeadSelectorPopup()" class="btn btn-light-success">Изменить</div>
                <user-selector-popup v-if="isHeadSelectorPopupOpened()"
                                     :close-popup-trigger="closeHeadSelectorPopup"
                                     @select-user="(user) => this.department.head = user">
                </user-selector-popup>
            </div>
            <div class="pb-6 border-b border-oceanic-lighter">
                <user-preview :user="department.head"
                ></user-preview>
            </div>
        </div>
        <div class="bg-oceanic-light p-6 mt-6">
            <div class="tracking-wider flex items-center text-gray-light text-xl mb-6">Описание</div>
            <textarea v-model="department.description"
                      rows="4"
                      class="p-3 text-gray bg-unset border border-blue-dark w-full ui-y-scroll">
            </textarea>
        </div>

        <div class="bg-oceanic-light p-6 pb-0 mt-6">
            <div class="flex">
                <div class="mr-2 tracking-wider text-gray-light text-xl">Сотрудники ({{ department.members.length }})</div>
                <div @click="openMemberSelectorPopup()" class="btn btn-light-add">
                    <i class="mr-1 fas fa-plus"></i>
                    <span class="">Добавить</span>
                </div>
            </div>
            <div class="grid grid-col-users-list gap-y-6 py-6">
                <user-preview-in-grid v-for="m of department.members" :user="m"
                                      action-button-text="Удалить"
                                      action-button-class="btn-light-delete"
                ></user-preview-in-grid>
            </div>
        </div>
    </div>
    <user-selector-popup v-if="isMemberSelectorPopupOpened()"
                         :close-popup-trigger="closeMemberSelectorPopup"
                         @select-user="">
    </user-selector-popup>
</template>

<script>
import UserSelectorPopup from "../User/UserSelectorPopup.vue";
import UserPreviewInGrid from "../User/UserPreviewInGrid.vue";
import UserPreview from "../User/UserPreview.vue";
import {User} from "../User/User.js";
import PageHeader from "../PageHeader.vue";
import {validationMixin} from "vuelidate";

export default {
    name: "department-edit",
    components: {PageHeader, UserPreview, UserPreviewInGrid, UserSelectorPopup},
    mixins: [validationMixin],
    props: {
        id: Number,
        name: String,
        description: String,
        headId: Number,
        membersIds: Array,
        storeUrl: String,
        updateUrl: String,
    },

    data() {
        let members = [];
        members.push(new User());

        let department = {
            id: this.id,
            name: this.name,
            description: this.description,
            head: new User(),
            members: members,
        }

        return {
            department: department,
            memberSelectorPopup: {
                opened: false,
                excludeUsers: [],
                search: ''
            },
            headSelectorPopup: {
                opened: false,
                excludeUsers: [],
                search: ''
            },
        }
    },
    methods: {
        /**
         * @param {string} search
         * @param {Number[]} excludeUsers
         */
        openMemberSelectorPopup(search = '', excludeUsers = []) {
            this.memberSelectorPopup.opened = true;
            this.memberSelectorPopup.search = search;
            this.memberSelectorPopup.excludeUsers = excludeUsers;
        },

        closeMemberSelectorPopup() {
            this.memberSelectorPopup.opened = false;
        },

        isMemberSelectorPopupOpened() {
            return this.memberSelectorPopup.opened;
        },

        /**
         * @param {string} search
         * @param {Number[]} excludeUsers
         */
        openHeadSelectorPopup(search = '', excludeUsers = []) {
            this.headSelectorPopup.opened = true;
            this.headSelectorPopup.search = search;
            this.headSelectorPopup.excludeUsers = excludeUsers;
        },

        closeHeadSelectorPopup() {
            this.headSelectorPopup.opened = false;
        },

        isHeadSelectorPopupOpened() {
            return this.headSelectorPopup.opened;
        },

        saveDepartment() {
            let membersIds = this.department.members.map((member) => member.id);
            let httpMethod = this.department.id > 0 ? 'put' : 'post';
            let url = this.department.id > 0 ? this.updateUrl : this.storeUrl;

            axios({
                method: httpMethod,
                url: url,
                data: {
                    headId: this.department.head.id,
                    membersIds: membersIds,
                    name: this.department.name,
                    description: this.department.description,
                }
            })
                .then(() => location.reload())
                .catch((error) => {
                    console.log(error)
                })
        }
    }
}
</script>


