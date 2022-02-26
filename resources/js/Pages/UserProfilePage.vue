<template>
    <page-header ref="pageHeader" :title="title">
        <template v-slot:icon>
            <i class="fas fa-user"></i>
        </template>
        <template v-slot:buttons>
            <a href="/users/" class="btn btn-light mr-4">
                <span>К списку</span>
            </a>
            <a v-if="isViewMode() && user.canBeUpdated" :href="editHref" class="btn btn-primary">
                <span>Редактировать</span>
            </a>
            <button v-if="isEditMode()" @click="sendSaveEvent()" class="btn btn-success">
                <span>Сохранить</span>
            </button>
        </template>
    </page-header>

    <page-body ref="pageBody" class="vld-parent">
        <template v-if="userId > 0">
            <transition name="fade">
                <loading v-model:active="isUserLoading"
                         :is-full-page="false"
                         loader="spinner"
                         color="#1976d2"
                         background-color="none"
                         :width="60"
                         blur="0"
                />
            </transition>
            <transition name="fade">
                <user-profile v-show="!isUserLoading"
                              ref="userDetails"
                              :user-id="userId"
                              :edit-mode="this.editMode"
                              @profile-load="onUserLoaded"/>
            </transition>
        </template>
        <template v-else>
            <user-profile ref="userDetails"
                          :user-id="userId"
                          :edit-mode="this.editMode"/>
        </template>
    </page-body>
</template>

<style scoped>
.fade-enter-active, .fade-leave-active {
    transition: opacity 0.3s;
}

.fade-enter-from, .fade-leave-to {
    opacity: 0;
}
</style>

<script>
import PageHeader from "../Components/PageHeader.vue";
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import PageBody from "../Components/PageBody.vue";
import UserProfile from "../Components/User/UserProfile.vue";
import {User} from "../Components/User/User.js";
import {ElementBoundingRect} from "../Services/Element/ElementBoundingRect.js";

export default {
    name: "UserProfilePage",
    components: {UserProfile, PageBody, PageHeader, Loading},

    props: {
        editMode: {
            type: Boolean,
            default: false
        },
        userId: Number,
    },

    data() {
        return {
            isUserLoading: true,
            user: new User()
        };
    },

    computed: {
        title: function () {
            if (this.isEditMode()) {
                return `Редактирование пользователя: ${this.user.getFullName()}`;
            }
            if (this.isCreateMode()) {
                return 'Добавление пользователя';
            }

            return `Просмотр пользователя: ${this.user.getFullName()}`;
        },

        editHref: function () {
            return `/users/${this.userId}/edit`;
        }
    },

    methods: {
        isEditMode() {
            return this.editMode && this.userId > 0;
        },

        isCreateMode() {
            return this.editMode && this.userId <= 0;
        },

        isViewMode() {
            return !this.editMode;
        },

        /** @param {User} user */
        onUserLoaded(user) {
            this.user = user;
            this.isUserLoading = false;
        },

        sendSaveEvent() {
            this.$refs.userDetails.save();
        }
    },

    mounted() {
        let headerHeight = this.$refs.pageHeader.$el.offsetHeight;
        let pageElemBounding = new ElementBoundingRect(this.$refs.pageBody.$el.parentElement);

        let pageBodyHeight = pageElemBounding.getOnlyHeight() - headerHeight;

        this.$refs.pageBody.$el.style.minHeight = pageBodyHeight + 'px';
    }
}
</script>

