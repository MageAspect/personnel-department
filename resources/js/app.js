import {createApp} from "vue";
import UserPreviewInGrid from "./Components/User/UserPreviewInGrid.vue";
import UserPreview from "./Components/User/UserPreview.vue";
import DepartmentEdit from "./Components/Department/DepartmentEdit.vue";
import PageHeader from "./Components/PageHeader.vue";
import DepartmentShow from "./Components/Department/DepartmentShow.vue";

require('./bootstrap');

const app = createApp({});
app.component(PageHeader.name, PageHeader);
app.component(UserPreview.name, UserPreview);
app.component(UserPreviewInGrid.name, UserPreviewInGrid);
app.component(DepartmentEdit.name, DepartmentEdit);
app.component(DepartmentShow.name, DepartmentShow);
app.mount('#app');


