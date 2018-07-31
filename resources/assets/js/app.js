
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import { Datetime } from 'vue-datetime';
import VueRouter from 'vue-router';
import Octicon from 'vue-octicon/components/Octicon.vue';
import 'vue-octicon/icons';

Vue.component('task-list', require('./components/TaskListComponent.vue'));
Vue.component('task-form', require('./components/TaskFormComponent.vue'));
Vue.component('calendar-view', require('./components/CalendarViewComponent.vue'));
Vue.component('list-view', require('./components/ListViewComponent.vue'));
Vue.component('alert-messages', require('./components/AlertMessagesComponent.vue'));
Vue.component('datetime', Datetime)
Vue.component('octicon', Octicon);

Vue.use(VueRouter);

/**
 * Routes
 */
const routes = [
  { path: '/', component: Vue.component('task-list') },
  { path: '/add', component: Vue.component('task-form') },
  { path: '/calendar', component: Vue.component('calendar-view') },
  { path: '/update/:id', component: Vue.component('task-form') },
]
const router = new VueRouter({
  routes
})

const app = new Vue({
  el: '#app',
  router
})
