<template>
    <div>
        <multiple-error v-if="saveErrors.length > 0" :errors="saveErrors"/>
        <div class="grid profile-grid gap-x-6">
            <div>
                <profile-block class="relative h-84 w-full h-full flex justify-center items-center">
                    <i v-if="user.avatarPath && editMode"
                       @click="removeAvatar"
                       class="fas fa-times absolute top-8 right-8 text-gray text-xl cursor-pointer"
                    >
                    </i>
                    <div @mousemove="showOpenPopupButton"
                         @mouseleave="hideOpenPopupButton"
                         class="relative overflow-hidden rounded-full h-56 w-56"
                    >
                        <div class="bg-cover bg-no-repeat bg-center w-inherit h-inherit"
                             :style="{'background-image': `url(${avatarPath}`}">
                        </div>
                        <transition v-if="editMode" name="fade">
                            <div v-if="isOpenDragAndDropPopupButtonShowed"
                                 class="absolute w-inherit h-inherit flex bg-oceanic/[.6]
                                justify-center items-center z-40 top-0 left-0"
                            >
                                <button @click="openDragAndDropPopup"
                                        class="btn text-white text-2xs p-2">
                                    Изменить
                                </button>
                            </div>
                        </transition>
                    </div>
                    <transition name="fade">
                        <drop-zone-popup v-if="isDragAndDropPopupShowed"
                                         :close-popup-trigger="closeDragAndDropPopup"
                                         @selectFile="updateAvatar"
                        />
                    </transition>
                </profile-block>
                <profile-block v-if="userId > 0" title="Состоит в отделах:">
                    <div class="max-h-72 overflow-y-scroll ui-y-scroll">
                        <department-preview v-for="department of userDepartments" :department="department"/>
                    </div>
                </profile-block>
            </div>
            <div>
                <profile-block title="Основная информация">
                    <named-field error="123" :edit-mode="editMode" class="mt-5" name="Фамилия"
                                 v-model:value="user.lastName"/>
                    <error v-if="v$.user.lastName.$dirty && v$.user.lastName.required.$invalid"
                           class="mt-2"
                           message="Фамилия обязательна для заполнения"/>
                    <error v-else-if="v$.user.lastName.$dirty && v$.user.lastName.minLength.$invalid"
                           class="mt-2"
                           message="Фамилия лишком короткая"/>
                    <error v-else-if="v$.user.lastName.$dirty && v$.user.lastName.maxLength.$invalid"
                           class="mt-2"
                           message="Фамилия лишком длинная"/>

                    <named-field :edit-mode="editMode" class="mt-5" name="Имя" v-model:value="user.name"/>
                    <error v-if="v$.user.name.$dirty && v$.user.name.required.$invalid"
                           class="mt-2"
                           message="Имя обязательно для заполнения"/>
                    <error v-else-if="v$.user.name.$dirty && v$.user.name.minLength.$invalid"
                           class="mt-2"
                           message="Имя лишком короткое"/>
                    <error v-else-if="v$.user.name.$dirty && v$.user.name.maxLength.$invalid"
                           class="mt-2"
                           message="Имя лишком длинное"/>

                    <named-field :edit-mode="editMode" class="mt-5" name="Отчество" v-model:value="user.patronymic"/>
                    <error v-if="v$.user.patronymic.$dirty && v$.user.patronymic.maxLength.$invalid"
                           class="mt-2"
                           message="Отчество лишком длинное"/>

                    <named-field :edit-mode="editMode" class="mt-5" name="Email" v-model:value="user.email"/>
                    <error v-if="v$.user.email.$dirty && v$.user.email.required.$invalid"
                           class="mt-2"
                           message="Email обязателен для заполнения"/>
                    <error v-else-if="v$.user.email.$dirty && v$.user.email.email.$invalid"
                           class="mt-2"
                           message="Неверный Email"/>

                    <named-field :edit-mode="editMode" class="mt-5" name="Должность" v-model:value="user.position"/>
                    <error v-if="v$.user.position.$dirty && v$.user.position.required.$invalid"
                           class="mt-2"
                           message="Должность обязательна для заполнения"/>
                    <error v-else-if="v$.user.position.$dirty && v$.user.position.minLength.$invalid"
                           class="mt-2"
                           message="Должность лишком короткая"/>
                    <error v-else-if="v$.user.position.$dirty && v$.user.position.maxLength.$invalid"
                           class="mt-2"
                           message="Должность лишком длинная"/>

                    <template v-if="user.salaryCanBeViewed || !this.userId">
                        <named-field :edit-mode="editMode" class="mt-5" name="Оклад в рублях"
                                     v-model:value="user.salary"/>
                        <error v-if="v$.user.salary.$dirty && v$.user.salary.required.$invalid"
                               class="mt-2"
                               message="Оклад обязателен для заполнения"/>
                        <error v-else-if="v$.user.salary.$dirty && v$.user.salary.minValue.$invalid"
                               class="mt-2"
                               message="Оклад слишком мал"/>
                        <error v-else-if="v$.user.salary.$dirty && v$.user.salary.maxValue.$invalid"
                               class="mt-2"
                               message="Оклад слишком велик"/>
                    </template>

                    <named-field :edit-mode="editMode"
                                 v-model:value="user.phone"
                                 maska="8 (###) ###-##-##"
                                 class="mt-5"
                                 name="Телефон"
                    />
                    <error v-if="v$.user.phone.$dirty && v$.user.phone.required.$invalid"
                           class="mt-2"
                           message="Телефон обязателен для заполнения"/>
                    <error v-else-if="v$.user.phone.$dirty && v$.user.phone.$invalid"
                           class="mt-2"
                           message="Телефон заполнен не полностью"/>
                </profile-block>

                <profile-block v-if="editMode" :title="userId > 0 ? 'Смена пароля' : 'Пароль'">
                    <template v-if="userId > 0">
                        <named-field :edit-mode="true" class="mt-5" name="Текущий пароль" type="password"
                                     v-model:value="currentPassword"/>
                        <error v-if="v$.currentPassword.$dirty && v$.currentPassword.requiredIf.$invalid"
                               class="mt-2"
                               message="Текущий пароль обязателен для заполнения при его смене"/>
                        <error v-if="v$.currentPassword.$dirty && v$.currentPassword.maxLength.$invalid"
                               class="mt-2"
                               message="Текущий пароль слишком длинный"/>
                    </template>

                    <named-field :edit-mode="true" class="mt-5" name="Новый пароль" type="password"
                                 v-model:value="newPassword"/>
                    <error v-if="v$.newPassword.$dirty && v$.newPassword.requiredIf.$invalid"
                           class="mt-2"
                           message="Новый пароль обязателен для заполнения"/>
                    <error v-else-if="v$.newPassword.$dirty && v$.newPassword.minLength.$invalid"
                           class="mt-2"
                           message="Новый пароль слишком короткий"/>
                    <error v-else-if="v$.newPassword.$dirty && v$.newPassword.maxLength.$invalid"
                           class="mt-2"
                           message="Новый пароль слишком длинный"/>

                    <named-field :edit-mode="true" class="mt-5" type="password" name="Подтверждение нового пароля"
                                 v-model:value="newPasswordConfirm"/>
                    <error v-if="v$.newPasswordConfirm.$dirty && v$.newPasswordConfirm.sameAs.$invalid"
                           class="mt-2"
                           message="Пароли не совпадают"/>
                </profile-block>

                <profile-block v-if="userId > 0" class="mb-0" title="Журнал продвижения по службе">
                    <journal-grid class="pt-3" :entries="careerJournal" :display-salary="user.salaryCanBeViewed"/>
                </profile-block>
            </div>
        </div>
    </div>
</template>

<style>
.profile-grid {
    grid-template-columns: 21rem minmax(25rem, 1fr);
}

.fade-enter-active, .fade-leave-active {
    transition: opacity 0.3s;
}

.fade-enter-from, .fade-leave-to {
    opacity: 0;
}
</style>

<script>
import {User} from "./User.js";
import ProfileBlock from "./Parts/ProfileBlock.vue";
import DropZonePopup from "../UI/Popup/DropZonePopup.vue";
import NamedField from "../UI/Field/NamedField.vue";
import DepartmentPreview from "./Parts/DepartmentPreview.vue";
import useVuelidate from "@vuelidate/core";
import {email, maxLength, maxValue, minLength, minValue, required, requiredIf, sameAs} from "@vuelidate/validators";
import Error from "../Department/Error.vue";
import {Department} from "../Department/Department.js";
import {JournalEntry} from "./JournalEntry.js";
import JournalGrid from "./Parts/JournalGrid.vue";
import MultipleError from "../UI/Error/MultipleError.vue";

export default {
    name: "UserProfile",
    components: {MultipleError, JournalGrid, Error, DepartmentPreview, NamedField, DropZonePopup, ProfileBlock},
    props: {
        editMode: {
            type: Boolean,
            required: true
        },
        userId: Number
    },
    emits: ['profileLoad'],


    setup() {
        return {v$: useVuelidate()}
    },

    data() {
        return {
            user: new User(),
            userDepartments: [],
            careerJournal: [],

            isDragAndDropPopupShowed: false,
            isOpenDragAndDropPopupButtonShowed: false,

            updatedAvatar: null,
            currentPassword: '',
            newPassword: '',
            newPasswordConfirm: '',

            saveErrors: ''
        }
    },

    computed: {
        avatarPath() {
            return this.user.avatarPath ? this.user.avatarPath : User.getDefaultAvatarPath()
        }
    },

    validations() {
        return {
            user: {
                name: {
                    required,
                    minLength: minLength(3),
                    maxLength: maxLength(100)
                },
                lastName: {
                    required,
                    minLength: minLength(3),
                    maxLength: maxLength(100)
                },
                patronymic: {
                    maxLength: maxLength(100)
                },
                email: {
                    required,
                    email
                },
                phone: {
                    required,
                    minLength: minLength(17),
                    maxLength: maxLength(17)
                },
                position: {
                    required,
                    minLength: minLength(3),
                    maxLength: maxLength(100)
                },
                salary: {
                    required,
                    minValue: minValue(1),
                    maxValue: maxValue(100000000),
                }
            },

            currentPassword: {
                requiredIf: requiredIf(false),
                maxLength: maxLength(40),
            },

            newPassword: {
                requiredIf: requiredIf(this.currentPassword || !this.userId),
                minLength: minLength(6),
                maxLength: maxLength(40),
            },
            newPasswordConfirm: {
                sameAs: sameAs(this.newPassword)
            }
        };
    },

    methods: {
        removeAvatar() {
            this.user.avatarPath = '';
        },

        openDragAndDropPopup() {
            this.isDragAndDropPopupShowed = true;
            this.hideOpenPopupButton();
        },

        closeDragAndDropPopup() {
            this.isDragAndDropPopupShowed = false;
        },

        showOpenPopupButton() {
            this.isOpenDragAndDropPopupButtonShowed = true;
        },

        hideOpenPopupButton() {
            this.isOpenDragAndDropPopupButtonShowed = false;
        },

        /**
         * @param {File} file
         */
        updateAvatar(file) {
            this.updatedAvatar = file;

            const reader = new FileReader();

            let onLoaded = (e) => {
                this.user.avatarPath = e.target.result;
                reader.removeEventListener('lead', onLoaded);
            }
            reader.addEventListener('load', onLoaded);

            reader.readAsDataURL(file);
        },

        save() {
            this.saveErrors = '';
            this.v$.$touch();
            if (this.v$.$error) {
                return;
            }

            let formData = new FormData();
            formData.append('name', this.user.name);
            formData.append('lastName', this.user.lastName);
            formData.append('patronymic', this.user.patronymic);
            formData.append('salary', this.user.salary);
            formData.append('position', this.user.position);
            formData.append('email', this.user.email);
            formData.append('phone', this.user.phone);
            if (this.currentPassword) {
                formData.append('currentPassword', this.currentPassword);
            }
            if (this.newPassword) {
                formData.append('newPassword', this.newPassword);
            }
            if (this.updatedAvatar) {
                formData.append('avatar', this.updatedAvatar);
            }

            if (!this.user.avatarPath) {
                formData.append('clearAvatar', true);
            }

            axios.post(
                this.userId > 0 ? `/users/${this.userId}` : '/users',
                formData
            )
                .then((response) => {
                    let id = this.userId ? this.userId : response.data.id;
                    location.href = `/users/${id}`;
                })
                .catch((axiosError) => {
                    if (axiosError.response.status !== 422) {
                        return this.saveErrors = ['Ошибка сохранения пользователя. Повторите позднее'];
                    }

                    let errors = Object.values(axiosError.response.data?.errors);

                    errors?.forEach(error => {
                        if (Array.isArray(error)) {
                            return this.saveErrors = [...this.saveErrors, ...error];
                        }

                        this.saveErrors.push(error);
                    });
                });
        }
    },

    mounted() {
        if (!this.userId) {
            return;
        }

        let pUser = axios.get(`/users/find/${this.userId}`)
            .then((response) => {
                this.user = User.fromJson(response.data);
            });

        let pDepartments = axios.get(`/departments/find-user-departments/${this.userId}`)
            .then((response) => {
                this.userDepartments = response.data
                    .map(jsonDepartment => Department.fromJson(jsonDepartment));
            });

        let pJournal = axios.get(`/users/find-career-journal/${this.userId}`)
            .then((response) => {
                this.careerJournal = response.data
                    .map(jsonJournal => JournalEntry.fromJson(jsonJournal));
            });

        Promise.all([pUser, pDepartments, pJournal])
            .then(() => this.$emit('profileLoad', this.user));
    }
}
</script>
