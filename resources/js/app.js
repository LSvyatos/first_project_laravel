
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Vuetify from 'vuetify'
import VueRouter from 'vue-router'
import Viewer from 'v-viewer'
import VueTelInput from 'vue-tel-input'
//import { i18n } from './plugins/i18n.js'
import VueHtmlToPaper from 'vue-html-to-paper';
const options = {
    name: '_blank',
    specs: [
      'fullscreen=yes',
      'titlebar=yes',
      'scrollbars=yes'
    ],
    
  }
Vue.use(VueHtmlToPaper,options);
Vue.use(Vuetify)
Vue.use(VueRouter)
Vue.use(Viewer)
Vue.use(VueTelInput)

import 'vuetify/dist/vuetify.min.css'
import 'vue-phone-number-input/dist/vue-phone-number-input.css';
import VueTelInputVuetify from 'vue-tel-input-vuetify/lib';

import Auth from './auth'

Vue.prototype.$auth = new Auth(window.user);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

//Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('admin', require('./components/Admin.vue').default);
Vue.component('VueTelInputVuetify',VueTelInputVuetify)
import Dashboard from './pages/Dashboard'
import Settings from './pages/Settings'
import Users from './pages/Users/Users'
import Clients from './pages/Users/Clients'
import Routes from './pages/Routes/Routes'
import RoutesChildren from './pages/Routes/RoutesChildren'
import TripActive from './pages/Trips/Trips'
import Vacancy from './pages/Vacancy/Vacancy'
import VacancyCategory from './pages/Vacancy/Category'
import Application from './pages/Applications/Application'
import City from './pages/Geography/City'
import Country from './pages/Geography/Country'
import Region from './pages/Geography/Region'
import Ticket from './pages/Tickets/Ticket'
import ticketReport from './pages/Tickets/Report'
import Transport from './pages/Transport/Transport'
import Trip from './pages/Trip'



import Roles from './pages/Roles'
import Permissions from './pages/Permissions'
import Activities from './pages/Activities'

const routes = [
  /*{
      path: '/admin',
      component: Dashboard
  },*/
    {
        path: '/applicationActive',
        component: Application
    },
    {
        path: '/vacancyActive',
        component: Vacancy,
        name: 'Вакансії'
    },
    {
        path: '/vacancyCategory',
        component: VacancyCategory,
        name: 'Категорії'
    },
    {
        path: '/tripActive',
        component: TripActive,
        name: 'Рейси'
    },
    {
        path: '/routesActive',
        component: Routes,
        name: 'Маршрути'
    },
    {
        path: '/routesRoute',
        component: RoutesChildren,
        name: 'Підмаршрути'
    },
    {
        path: '/ticketReport',
        component: ticketReport
    },
    {
        path: '/ticket',
        component: Ticket
    },
    {
        path: '/trip',
        component: Trip
    },
    {
        path: '/transport',
        component: Transport
    },
    {
        path: '/clients',
        component: Clients,

    },
    {
        path: '/city',
        component: City,

    },
    {
        path: '/country',
        component: Country,

    },
    {
        path: '/region',
        component: Region,

    },
  {
      path: '/users',
      component: Users
  },
  {
      path: '/settings',
      component: Settings
  }/*,
  {
      path: '/activities',
      component: Activities
  }*/
];

const router = new VueRouter({
  mode: 'history',
  routes
})


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router
});

