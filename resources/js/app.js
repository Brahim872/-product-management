import './bootstrap'
import {createApp} from 'vue';
import Home from './Pages/home.vue';
import authentication from './Pages/auth.vue';
import router from "./Routes/index";
const app = createApp({});

app.component("home",Home);
app.component("auth",authentication);
app.use(router)
app.mount('#app');

