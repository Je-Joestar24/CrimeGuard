

import './bootstrap.js';
import { createApp } from 'vue';
import App from './App.vue';
import store from './util/index.js';
import highcharts from 'highcharts';
import routes from './util/routes.js';
import { MotionPlugin } from '@vueuse/motion';


const app = createApp(
    App
);
app.use(store);
app.use(MotionPlugin);
app.use(highcharts);
app.use(routes);



app.mount('#app');
