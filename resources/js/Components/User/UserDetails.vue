<template>
    <div class="grid profile-grid gap-x-6">
        <div>
            <profile-block class="relative h-84 w-full h-full flex justify-center items-center">
                <i v-if="user.avatarPath"
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
                    <transition name="fade">
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
                    <drag-and-drop-file-popup v-if="isDragAndDropPopupShowed"
                                              :close-popup-trigger="closeDragAndDropPopup"
                                              @selectFile="updateAvatar"
                    />
                </transition>
            </profile-block>
            <profile-block title="Состоит в отделах:">
                <department-preview v-for="department of userDepartments" :department="department" />
            </profile-block>
        </div>
        <div>
            <profile-block title="Основная информация">
                <named-field :edit-mode="editMode" class="mt-5" name="Фамилия" v-model:value="user.lastName"/>
                <named-field :edit-mode="editMode" class="mt-5" name="Имя" v-model:value="user.name"/>
                <named-field :edit-mode="editMode" class="mt-5" name="Отчество" v-model:value="user.patronymic"/>
                <named-field :edit-mode="editMode" class="mt-5" name="Email" v-model:value="user.email"/>
                <named-field :edit-mode="editMode" class="mt-5" name="Должность" v-model:value="user.position"/>
                <named-field :edit-mode="editMode" v-if="user.salaryCanBeViewed" class="mt-5" name="Оклад в рублях"
                             v-model:value="user.salary"/>
                <named-field :edit-mode="editMode" class="mt-5" name="Телефон" v-model:value="user.phone"/>
            </profile-block>
            <profile-block v-if="editMode" title="Смена пароля">
                <named-field :edit-mode="true" class="mt-5" name="Текущий пароль" v-model:value="user.lastName"/>
                <named-field :edit-mode="true" class="mt-5" name="Новый пароль" v-model:value="user.lastName"/>
                <named-field :edit-mode="true" class="mt-5" name="Подтверждение нового пароля"
                             v-model:value="user.lastName"/>
            </profile-block>
            <profile-block class="mb-0" title="Журнал продвижения по службе">
            </profile-block>
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
import {Department} from "../Department/Department.js";
import ProfileBlock from "./Parts/ProfileBlock.vue";
import DragAndDropFilePopup from "../UI/Popup/DragAndDropFilePopup.vue";
import NamedField from "../UI/Field/NamedField.vue";
import DepartmentPreview from "./Parts/DepartmentPreview.vue";

export default {
    name: "UserDetails",
    components: {DepartmentPreview, NamedField, DragAndDropFilePopup, ProfileBlock},
    props: {
        editMode: {
            type: Boolean,
            required: true
        }
    },
    emits: ['profileLoad'],

    data() {
        return {
            user: User.fromJson({avatar: '/img/user/user.jpg'}),
            userDepartments: [],
            isDragAndDropPopupShowed: false,
            isOpenDragAndDropPopupButtonShowed: false,
            userUpdatedAvatar: null,
        }
    },

    computed: {
        avatarPath() {
            return this.user.avatarPath ? this.user.avatarPath : User.getDefaultAvatarPath()
        }
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
            this.userUpdatedAvatar = file;

            const reader = new FileReader();

            let onLoaded = (e) => {
                this.user.avatarPath = e.target.result;
                reader.removeEventListener('lead', onLoaded);
            }
            reader.addEventListener('load', onLoaded);

            reader.readAsDataURL(file);
        },

        loadUser() {}
    },

    mounted() {
        setTimeout(
            () => {
                this.$emit('profileLoad', new User())
            },
            300
        );
    }
}
</script>
