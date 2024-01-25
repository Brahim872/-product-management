import './bootstrap'
import {createApp} from 'vue';
import Home from './Pages/home.vue';
import authentication from './Pages/Auth/auth.vue';
import router from "./Routes/index";
import Select2 from 'v-select2-component';
import axios from './Plugins/axios.js'; // Adjust the path accordingly

const app = createApp({});
app.component('Select2', Select2);
app.component("home",Home);
app.component("auth",authentication);
app.config.globalProperties.$axios = axios;
app.use(router)
app.mount('#app');

