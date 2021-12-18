import Hello from "./Components/Hello.vue";

require('./bootstrap');

import {createApp} from "vue";
const app = createApp({});

app.component('component-hello', Hello);
app.mount('#app')
