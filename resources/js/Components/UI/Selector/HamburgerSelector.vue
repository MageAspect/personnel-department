<template>
    <div class="relative">
        <i class="fas fa-bars text-blue font-light cursor-pointer" @click="openItemsList()"></i>
        <transition name="fade">
            <div v-if="isItemsOpened" ref="itemsListContainer"
                 class="absolute bg-oceanic-light text-sm text-gray-lighter z-50">
                <template v-for="item of items">
                    <a v-if="item.hasOwnProperty('link')"
                        :class="[...item.classes, 'py-2', 'px-3', 'transition', 'border-b' , 'border-oceanic']"
                        :href="item.link"
                    >
                        {{ item.text }}
                    </a>
                    <div v-else
                       :class="[...item.classes, 'py-2', 'px-3', 'transition', 'border-b' , 'border-oceanic', 'cursor-pointer']"
                       @click="[item.clickHandler(), closeItemsList()]"
                    >
                        {{ item.text }}
                    </div>
                </template>

            </div>
        </transition>
    </div>
</template>

<style scoped>
.fade-enter-active, .fade-leave-active {
    transition: opacity 0.2s;
}

.fade-enter-from, .fade-leave-to {
    opacity: 0;
}
</style>

<script>
export default {
    name: "HamburgerSelector",
    props: {
        items: Array
    },

    data() {
        return {
            isItemsOpened: false
        }
    },

    methods: {
        openItemsList() {
            if (this.isItemsOpened) {
                return;
            }

            this.isItemsOpened = true;

            setTimeout(() => window.addEventListener('click', this.handleWindowClickToCloseList), 0);
        },

        closeItemsList() {
            if (!this.isItemsOpened) {
                return;
            }

            this.isItemsOpened = false;

            window.removeEventListener('click', this.handleWindowClickToCloseList)
        },

        handleWindowClickToCloseList(e) {
            let isClickedOnListContainer = this.$refs.itemsListContainer.contains(e.target)
                || this.$refs.itemsListContainer === e.target;

            if (!isClickedOnListContainer) {
                this.closeItemsList();
            }
        }
    },

    created: function () {

    },

    destroyed: function () {
    }
}
</script>

<style scoped>

</style>
