import Vue from "vue";
import UserSelectorPopup from "./Components/UserSelectorPopup.vue";
import UserPreview from "./Components/UserPreview.vue";
import UserPreviewInGrid from "./Components/UserPreviewInGrid.vue";
require('./bootstrap');
Vue.component(UserPreview.name, UserPreview);
Vue.component(UserPreviewInGrid.name, UserPreviewInGrid);
Vue.component(UserSelectorPopup.name, UserSelectorPopup);
new Vue({el: '#app'});



