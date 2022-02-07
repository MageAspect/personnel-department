import {createApp} from "vue";
import UserPreviewInGrid from "./Components/User/UserPreviewInGrid.vue";
import UserPreview from "./Components/User/UserPreview.vue";
import DepartmentEdit from "./Components/Department/DepartmentEdit.vue";
import PageHeader from "./Components/PageHeader.vue";
import DepartmentShow from "./Components/Department/DepartmentShow.vue";
import Error from "./Components/Department/Error.vue";
import UserListPage from "./Pages/UserListPage.vue";
import UserDetailsPage from "./Pages/UserDetailsPage.vue";

require('./bootstrap');

const app = createApp({});
app.component(Error.name, Error);
app.component(PageHeader.name, PageHeader);

app.component(UserPreview.name, UserPreview);
app.component(UserPreviewInGrid.name, UserPreviewInGrid);
app.component(UserListPage.name, UserListPage);
app.component(UserDetailsPage.name, UserDetailsPage);

app.component(DepartmentEdit.name, DepartmentEdit);
app.component(DepartmentShow.name, DepartmentShow);

app.mount('#app');


