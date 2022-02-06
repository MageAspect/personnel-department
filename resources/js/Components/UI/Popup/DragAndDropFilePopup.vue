<template>
    <full-screen-popup :close-popup-trigger="closePopupTrigger">
          123
    </full-screen-popup>
</template>

<script>
import FullScreenPopup from "./FullScreenPopup.vue";

export default {
    name: "DragAndDropFilePopup",
    components: {FullScreenPopup},

    props: {
        closePopupTrigger: {
            type: Function,
            required: true
        }
    }
}
</script>

