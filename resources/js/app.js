import Hello from "./Components/Hello.vue";
import UIButton from "./Components/UIButton.vue";

require('./bootstrap');

import {createApp} from "vue";
const app = createApp({});

app.component('component-hello', Hello);
app.component('ui-button', UIButton);
app.mount('#app')
