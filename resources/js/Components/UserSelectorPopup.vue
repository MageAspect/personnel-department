<template>
    <div v-if="show" class="absolute top-0 left-0 bg-popup w-full-screen h-full-screen">
        <div class="w-full h-full flex items-center justify-center">
            <div><i class="fa-regular fa-xmark"></i></div>
            <div class="bg-oceanic-light w-fit py-10 px-8">
                <div class="grid grid-col-users-list gap-y-6 ui-y-scroll max-h-96 px-2">
                    <user-preview-in-grid :id="34"
                                          name="Станислав"
                                          last-name="Башкиров"
                                          position="Генеральный директор"
                                          phone="8 (555) 444 27-54"
                                          email="bash@mosowell.ru"
                                          profile-link="/123/"
                                          avatar-path="/img/user/user.jpg"
                                          action-button-text="Выбрать"
                                          action-button-class="btn-light-add"
                    ></user-preview-in-grid>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import UserPreviewInGrid from "./UserPreviewInGrid.vue";

export default {
    name: "user-selector-popup",
    components: {UserPreviewInGrid},

    data() {
        return {
            show: true
        }
    },
    methods: {
        close(e) {
            if (e.keyCode !== 27) {
                return;
            }

            window.removeEventListener('keydown', this.close);
            this.show = false
        }
    },
    created: function () {
        window.addEventListener('keydown', this.close);
    },
    destroyed: function () {
        window.removeEventListener('keydown', this.close);
    }
}
</script>

