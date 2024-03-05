
import 'bootstrap/dist/css/bootstrap.min.css';

import { createApp } from 'vue';
import App from './vue/Components/App.vue';
import router from './vue/router';

const app = createApp(App);
app.use(router);
app.mount('#app');