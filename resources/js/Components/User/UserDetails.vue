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
            <profile-block title="Основная информация">
                123
            </profile-block>
        </div>
        <div>
            <profile-block title="Основная информация">
                123
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
import ProfileBlock from "./Parts/ProfileBlock.vue";
import DragAndDropFilePopup from "../UI/Popup/DragAndDropFilePopup.vue";

export default {
    name: "UserDetails",
    components: {DragAndDropFilePopup, ProfileBlock},
    emits: ['userLoad'],

    data() {
        return {
            user: User.fromJson({avatar: '/img/user/user.jpg'}),
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
        }
    },

    mounted() {
        setTimeout(
            () => {
                this.$emit('userLoad', new User())
            },
            300
        );
    }
}
</script>
