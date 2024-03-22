import './bootstrap';
import { createApp } from 'vue'
import App from "./components/App.vue";
import router from "./routes.js";
import Auth from "./helpers/auth.js";

const app = createApp({})

app.component('app', App)
app.use(router, Auth)

app.mount('#app')
