<template>
    <full-screen-popup :close-popup-trigger="closePopupTrigger">
        <div @dragenter.prevent="toggleHighlight"
             @dragleave.prevent="toggleHighlight"
             @dragover.prevent
             @drop.prevent="dropFile"
             class="border-2 border-dashed h-48 transition
                      flex flex-col items-center justify-center text-gray"
             :class="{'border-blue-dark': !areaHighlighted, 'border-blue': areaHighlighted}"
        >
            <div class="mb-2">Перетащите файл в выделенную область</div>
            <div class="mb-2">или</div>
            <label class="btn btn-primary text-2xs p-3">
                Выберите файл
                <input @input="inputFile" type="file" accept="image/jpeg,image/png,image/jpg" class="hidden">
            </label>
        </div>
    </full-screen-popup>
</template>

<script>
import FullScreenPopup from "./FullScreenPopup.vue";

export default {
    name: "DropZonePopup",
    components: {FullScreenPopup},
    emits: ['selectFile'],

    props: {
        closePopupTrigger: {
            type: Function,
            required: true
        }
    },

    data() {
        return {
            areaHighlighted: false
        }
    },

    methods: {
        toggleHighlight() {
            this.areaHighlighted = !this.areaHighlighted;
        },

        dropFile(e) {
            this.emitSelectFile(e.dataTransfer.files[0]);
        },

        inputFile(e) {
            this.emitSelectFile(e.target.files[0]);
        },

        /**
         * @param {File} file
         */
        emitSelectFile(file) {
            if (!file) {
                return;
            }

            this.$emit('selectFile', file);
            this.closePopupTrigger();
        }
    }
}
</script>

