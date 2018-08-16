
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


import Vue from 'vue'
import VueRouter from 'vue-router'
import ElementUI from 'element-ui'
import Vuex from 'vuex'
import AdminApp from './Admin.vue'
import AdminRouter from './router/admin-router.js'

import 'element-ui/lib/theme-default/index.css'
import './assets/theme/theme-green/index.css'
import 'font-awesome/css/font-awesome.min.css'
import axios from 'axios';
require('./sass/admin.scss');

Vue.use(VueRouter);
Vue.use(ElementUI);
Vue.use(Vuex);

/*
import index from './components/index.vue'
import hello from './components/hello.vue'

//  定义路由
const routes = [
    {path: '/', component: require('./components/Example.vue')},
    { path: '/index', component: index },
    { path: '/hello', component: hello },
];
*/
//  创建 router 实例，然后传 routes 配置
const router = new VueRouter({
    routes : AdminRouter
});

// import {requestLogout} from 'api/api';

router.beforeEach((to, from, next) => {
    //NProgress.start();
    if (to.path == '/login') {
        axios.post(`/logout`).then((result) => {
            sessionStorage.removeItem('user');
        });
    }
    let user = JSON.parse(sessionStorage.getItem('user'));
    if (!user && to.path != '/login') {
        next({ path: '/login' })
    } else {
        next()
    }
});

//  .创建和挂载根实例。通过 router 配置参数注入路由，从而让整个应用都有路由功能

const app = new Vue({
    router,
    render: h => h(AdminApp)
}).$mount('#app');

