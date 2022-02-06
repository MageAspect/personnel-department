<template>
    <div class="fixed top-0 left-0 bg-popup w-full-screen h-full-screen">
        <div class="w-full h-full flex items-center justify-center">
            <div v-if="initialized" class="bg-oceanic-light w-fit pt-10 pb-8 px-8 min-w-182.25 relative">
                <div class="absolute -top-12 -right-8">
                    <i @click="closePopupTrigger"
                       class="cursor-pointer text-2xl text-gray-light  fa-solid fa-xmark">
                    </i>
                </div>
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "FullScreenPopup",

    props: {
        closePopupTrigger: {
            type: Function,
            required: true,
        },
        initialized: {
            type: Boolean,
            default: true,
        }
    },

    methods: {
        closePopup(e) {
            if (e.keyCode !== 27) {
                return;
            }

            this.closePopupTrigger();
        }
    },

    mounted() {
        document.body.style.overflow = 'hidden';
        window.addEventListener('keydown', this.closePopup);
    },

    unmounted() {
        document.body.style.removeProperty('overflow');
        window.removeEventListener('keydown', this.closePopup);
    }
}
</script>

