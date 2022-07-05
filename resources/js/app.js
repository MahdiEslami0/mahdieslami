
import Vue from 'vue'
window.Vue = require('vue');
import App from './app.vue';
import VueMeta from 'vue-meta';
import 'bootstrap/dist/js/bootstrap'
import VueCompositionApi from '@vue/composition-api';
import router from "./router/router";
import VueRouter from 'vue-router';

Vue.use(VueRouter);
Vue.use(require('vue-cookies'))
Vue.use(VueCompositionApi);
Vue.use(VueMeta);
const app = new Vue({
    el: '#app',
    render: h => h(App),
    router,
});