
import './bootstrap';
import { createApp } from 'vue';
import app from './components/app.vue';
import router from './router';
import store from './store';



import '../css/app.css';
import 'vue-good-table-next/dist/vue-good-table-next.css';
createApp(app)
.use(router)
.use(store)
.mount('#app');

