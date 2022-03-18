require('./bootstrap');

import Vue from 'vue/dist/vue';
window.Vue = require('vue');

import App from './components/App';

const Home = Vue.component('Home', (resolve) => {
  import(/* webpackChunkName: "Home" */'./components/Pages/Home.vue')
    .then((Home) => {
      resolve(Home.default);
    });
});
const Login = Vue.component('Login', (resolve) => {
  import(/* webpackChunkName: "Login" */'./components/Auth/Login.vue')
    .then((Login) => {
      resolve(Login.default);
    });
});
const Register = Vue.component('Register', (resolve) => {
  import(/* webpackChunkName: "Register" */'./components/Auth/Register.vue')
    .then((Register) => {
      resolve(Register.default);
    });
});
const Forms = Vue.component('Forms', (resolve) => {
  import(/* webpackChunkName: "Forms" */'./components/Pages/Forms.vue')
    .then((Forms) => {
      resolve(Forms.default);
    });
});
const Profile = Vue.component('Profile', (resolve) => {
  import(/* webpackChunkName: "Profile" */'./components/Pages/Profile.vue')
    .then((Profile) => {
      resolve(Profile.default);
    });
});
const TelcoRequest = Vue.component('TelcoRequest', (resolve) => {
  import(/* webpackChunkName: "TelcoRequest" */'./components/Pages/TelcoRequest.vue')
    .then((TelcoRequest) => {
      resolve(TelcoRequest.default);
    });
});
//page not found
const PageNotFound = Vue.component('PageNotFound', (resolve) => {
  import(/* webpackChunkName: "PageNotFound" */'./components/Error/PageNotFound.vue')
    .then((PageNotFound) => {
      resolve(PageNotFound.default);
    });
});

import Vuex from 'vuex'
import VueRouter from 'vue-router';
import VueToast from 'vue-toast-notification';
import Vuelidate from 'vuelidate'
import VueCookies from 'vue-cookies'
import { library } from '@fortawesome/fontawesome-svg-core'
import { faUserGear } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

Vue.use(Vuex)
Vue.use(VueRouter)
Vue.use(VueToast)
Vue.use(Vuelidate)
Vue.use(VueCookies)

library.add(faUserGear)
Vue.component('font-awesome-icon', FontAwesomeIcon)
Vue.config.productionTip = false

const router = new VueRouter({
        mode: 'history',
        routes: [
            {
                path: '/',
                name: 'home',
                component: Home
            },
            {
                path: '/login',
                name: 'login',
                component: Login
            },
            {
                path: '/register',
                name: 'register',
                component: Register
            },
            {
                path: '/profile',
                name: 'profile',
                component: Profile
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
            },
            {
                path: '/*',
                name: 'page_not_found',
                component: PageNotFound,
            },
        ]
});

Vue.prototype.$ajaxGet = function(access_token, url, success_callback, error_callback)
{
    $.ajax({
        type: 'GET',
        url: url,
        cache: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            "Content-Type": "application/x-www-form-urlencoded",
            "Authorization": "Bearer "+access_token
        },
        success: function (data) {
            success_callback(data);
        },
        error: function (data) {
            error_callback(data);
        },
    });
}

Vue.prototype.$ajaxPost = function(access_token, post_data, url, success_callback, error_callback)
{
    $.ajax({
        type: 'POST',
        url: url,
        data: post_data,
        cache: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            "Content-Type": "application/x-www-form-urlencoded",
            "Authorization": "Bearer "+access_token
        },
        beforeSend : function() {

        },
        success: function (data) {
            success_callback(data);
        },
        error: function (data) {
            error_callback(data);
        },
        complete : function() {

        }
    });
}

Vue.prototype.$error = function(error)
{
    this.$toast.error(error, {
        position: 'top'
    })
    if (error.status == 401) {
        setTimeout(() => {
            window.location.href = '/login'
        }, 1500)
    }
}

Vue.prototype.$capitalizeFirstLetter = function(str)
{
    if (str) {
        const arr = str.split(" ")

        for (var i = 0; i < arr.length; i++) {
            arr[i] = arr[i].charAt(0).toUpperCase() + arr[i].slice(1)

        }

        const str2 = arr.join(" ")
        return str2
    }
}

const app = new Vue({
        el: '#app',
        components: {App},
        router
});