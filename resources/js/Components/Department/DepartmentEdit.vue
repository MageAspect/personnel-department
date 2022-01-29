<template>
    <page-header v-model:title-input="department.name" title="Редактирование:">
        <template v-slot:icon>
            <i class="fas fa-layer-group"></i>
        </template>
        <template v-slot:buttons>
            <a href="/departments/" class="btn btn-light mr-4">
                <span>К списку</span>
            </a>
            <button :disabled="saveDisabled" class="btn btn-success" @click.prevent="saveDepartment()">
                <span>Сохранить</span>
            </button>
        </template>
        <template v-slot:input-error>
            <error v-if="v$.department.name.$dirty && v$.department.name.required.$invalid"
                   message="Название должно быть заполнено"
                   margin-top
            >
            </error>
            <error v-else-if="v$.department.name.$dirty && v$.department.name.minLength.$invalid"
                   message="Название должно содержать минимум 3 символа"
                   margin-top
            >
            </error>
            <error v-else-if="v$.department.name.$dirty && v$.department.name.maxLength.$invalid"
                   message="Название должно должно превышать 100 символов"
                   margin-top
            >
            </error>
        </template>
    </page-header>
    <div class="p-6 pb-0">
        <error v-if="saveError" margin-bottom :message="saveError"></error>

        <div class="bg-oceanic-light p-6">
            <div class="flex mb-6">
                <div class="tracking-wider text-gray-light text-xl mr-3">Руководитель отдела</div>
                <div @click="openHeadSelectorPopup()" class="btn btn-light-success">Изменить</div>
                <transition name="bounce">
                    <user-selector-popup v-if="isHeadSelectorPopupOpened()"
                                         :close-popup-trigger="closeHeadSelectorPopup"
                                         :find-users-url="findUsersUrl"
                                         :excluded-ids="getExcludedIds()"
                                         @select-user="selectHead">
                    </user-selector-popup>
                </transition>
            </div>
            <div class="pb-6 border-b border-oceanic-lighter">
                <user-preview v-if="department.head" :user="department.head"
                ></user-preview>
            </div>
            <error v-if="v$.department.head.$dirty && v$.department.head.required.$invalid"
                   message="Руководитель отдела должен быть заполнен"
                   margin-top
            >
            </error>
        </div>
        <div class="bg-oceanic-light p-6 mt-6">
            <div class="tracking-wider flex items-center text-gray-light text-xl mb-6">Описание</div>
            <textarea v-model="department.description"
                      rows="4"
                      class="p-3 text-gray bg-unset border border-blue-dark w-full ui-y-scroll">
            </textarea>
            <error v-if="v$.department.description.$dirty && v$.department.description.required.$invalid"
                   message="Описание отдела обязательно для заполнения"
                   margin-top
            >
            </error>
            <error v-else-if="v$.department.description.$dirty && v$.department.description.minLength.$invalid"
                   message="Описание должно содержать минимум 20 символов"
                   margin-top
            >
            </error>
            <error v-else-if="v$.department.description.$dirty && v$.department.description.maxLength.$invalid"
                   message="Описание не должно превышать 1000 символов"
                   margin-top
            >
            </error>
        </div>

        <div class="bg-oceanic-light p-6 pb-0 mt-6">
            <div class="flex">
                <div class="mr-2 tracking-wider text-gray-light text-xl">
                    Сотрудники ({{ department.members.length }})
                </div>
                <div @click="openMemberSelectorPopup()" class="btn btn-light-add">
                    <i class="mr-1 fas fa-plus"></i>
                    <span class="">Добавить</span>
                </div>
            </div>
            <div class="grid grid-col-users-list gap-y-6 py-6">
                <user-preview-in-grid v-for="m of department.members" :user="m"
                                      action-button-text="Удалить"
                                      action-button-class="btn-light-delete"
                                      @select-user="deleteMember"
                ></user-preview-in-grid>
            </div>
        </div>
    </div>
    <transition name="bounce">
        <user-selector-popup v-if="isMemberSelectorPopupOpened()"
                             :close-popup-trigger="closeMemberSelectorPopup"
                             :find-users-url="findUsersUrl"
                             :excluded-ids="getExcludedIds()"
                             @select-user="addMember">
        </user-selector-popup>
    </transition>
</template>

<style scoped>
.bounce-enter-active {
    animation: bounce-in 0.7s;
}

.bounce-leave-active {
    animation: bounce-out 0.5s;
}

@keyframes bounce-in {
    0% {
        transform: scale(0);
    }
    50% {
        transform: scale(1.25);
    }
    100% {
        transform: scale(1);
    }
}

@keyframes bounce-out {
    0% {
        transform: scale(1);
        opacity: 1
    }
    100% {
        transform: scale(0);
        opacity: 0
    }
}

.fade-enter-active, .fade-leave-active {
    transition: opacity 0.6s ease;
}

.fade-enter-from, .fade-leave-to {
    opacity: 0;
}
</style>

<script>
import UserSelectorPopup from "../User/UserSelectorPopup.vue";
import UserPreviewInGrid from "../User/UserPreviewInGrid.vue";
import UserPreview from "../User/UserPreview.vue";
import {User} from "../User/User.js";
import PageHeader from "../PageHeader.vue";
import useVuelidate from '@vuelidate/core'
import {maxLength, minLength, required} from '@vuelidate/validators'
import Error from "./Error.vue";
import {Department} from "./Department.js";

export default {
    name: "department-edit",
    components: {Error, PageHeader, UserPreview, UserPreviewInGrid, UserSelectorPopup},
    props: {
        jsonDepartment: JSON,
        storeUrl: String,
        updateUrl: String,
        viewUrl: String,
        findUsersUrl: String,
    },

    methods: {
        openMemberSelectorPopup() {
            this.memberSelectorPopup.opened = true;
            this.memberSelectorPopup.search = '';
            this.memberSelectorPopup.excludeUsers = this.department.members.map(user => user.id);
        },

        closeMemberSelectorPopup() {
            this.memberSelectorPopup.opened = false;
        },

        isMemberSelectorPopupOpened() {
            return this.memberSelectorPopup.opened;
        },

        getExcludedIds() {
            let excluded = this.department.members.map(user => user.id);
            excluded.push(this.department.head.id);

            return excluded;
        },

        openHeadSelectorPopup() {
            this.headSelectorPopup.opened = true;
            this.headSelectorPopup.search = '';
            this.headSelectorPopup.excludeUsers = [this.department.head.id];
        },

        closeHeadSelectorPopup() {
            this.headSelectorPopup.opened = false;
        },

        isHeadSelectorPopupOpened() {
            return this.headSelectorPopup.opened;
        },

        /**
         * @param {User} user
         */
        selectHead(user) {
            this.closeHeadSelectorPopup();
            this.department.head = user;
        },

        /**
         * @param {User} memberToDelete
         */
        deleteMember(memberToDelete) {
            this.department.members = this.department.members.filter(user => user.id !== memberToDelete.id);
        },

        /**
         * @param {User} memberToAdd
         */
        addMember(memberToAdd) {
            this.department.members.push(memberToAdd);
        },

        saveDepartment() {
            this.saveError = '';
            this.v$.department.$touch();
            if (this.v$.$error) {
                return;
            }

            this.saveDisabled = true;
            axios({
                method: this.department.id > 0 ? 'put' : 'post',
                url: this.department.id > 0 ? `/departments/${this.department.id}` : '/departments',
                data: {
                    headId: this.department.head.id,
                    membersIds: this.department.members.map(member => member.id),
                    name: this.department.name,
                    description: this.department.description,
                }
            })
                .then((response) => {
                    if (this.department.id > 0) {
                        location.href = `/departments/${this.department.id}`
                    } else {
                        location.href = `/departments/${response.data.id}`
                    }
                })
                .catch((axiosError) => {
                    if (axiosError.response.data.hasOwnProperty('error')) {
                        this.saveError = axiosError.response.data.error;
                    } else {
                        this.saveError = 'Что-то пошло не так. Повторите позднее';
                    }
                })
                .finally(() => this.saveDisabled = false)
        }
    },

    created() {
        this.department = Department.fromJson(this.jsonDepartment);
    },

    setup() {
        return {v$: useVuelidate()}
    },

    data() {
        return {
            department: new Department(),
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
            saveError: '',
            saveDisabled: false
        }
    },

    validations() {
        return {
            department: {
                head: {required},
                name: {
                    required,
                    minLength: minLength(3),
                    maxLength: maxLength(100)
                },
                description: {
                    required,
                    minLength: minLength(20),
                    maxLength: maxLength(1000)
                },
            }
        };
    },
}
</script>


