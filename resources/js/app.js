require('./bootstrap');

import Vue from 'vue/dist/vue';
window.Vue = require('vue');

import VueRouter from 'vue-router';

import App from './components/App'
import Home from "./components/Pages/Home";
import Forms from "./components/Pages/Forms";
import TelcoRequest from "./components/Pages/TelcoRequest";
import VueToast from 'vue-toast-notification';
import Vuelidate from 'vuelidate'

Vue.use(VueRouter);
Vue.use(VueToast);
Vue.use(Vuelidate)

const router = new VueRouter({
        mode: 'history',
        routes: [
            {
                path: '/',
                name: 'home',
                component: Home
            },
            {
                path: '/forms',
                name: 'forms',
                component: Forms
            },
            {
                path: '/telco-request',
                name: 'telco_request',
                component: TelcoRequest
            }
        ]
});

const app = new Vue({
        el: '#app',
        components: {App},
        router
});