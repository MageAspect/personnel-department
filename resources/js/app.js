
import {createApp} from "vue";
import UserPreview from "./Components/UserPreview.vue";
import UserPreviewInGrid from "./Components/UserPreviewInGrid.vue";
import UserSelectorPopup from "./Components/UserSelectorPopup.vue";

require('./bootstrap');

const app = createApp({});
app.component(UserPreview.name, UserPreview);
app.component(UserPreviewInGrid.name, UserPreviewInGrid);
app.component(UserSelectorPopup.name, UserSelectorPopup);
app.mount('#app')


