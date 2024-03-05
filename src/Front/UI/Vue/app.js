
import 'bootstrap/dist/css/bootstrap.min.css';

import { createApp } from 'vue';
import App from './Components/App.vue';
import router from './Router/router';

const app = createApp(App);
app.use(router);
app.mount('#app');