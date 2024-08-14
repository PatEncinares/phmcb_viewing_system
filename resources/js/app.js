/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

import Vue from "vue";

import VueSimpleAlert from "vue-simple-alert";
import { ClientTable } from 'vue-tables-2';

import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';

Vue.use(ClientTable, {}, false, 'bootstrap4');

// main.js

Vue.use(VueSimpleAlert);
Vue.component('v-select', vSelect);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('home-component', require('./components/ExampleComponent.vue').default);

// PARTIALS
Vue.component('breadcrumb-component', require('./components/partials/BreadCrumbComponent.vue').default);
Vue.component('form-component', require('./components/partials/FormComponent.vue').default);
Vue.component('modal-component', require('./components/partials/ModalComponent.vue').default);
// END OF PARTIALS

//MASTER DATA
Vue.component('doctor-details-component', require('./components/masterData/DoctorDetailsComponent.vue').default);
Vue.component('specialization-component', require('./components/masterData/SpecializationComponent.vue').default);
Vue.component('sub-specialization-component', require('./components/masterData/SubSpecializationComponent.vue').default);
Vue.component('hmo-component', require('./components/masterData/HmoComponent.vue').default);
Vue.component('building-component', require('./components/masterData/BuildingComponent.vue').default);
Vue.component('rooms-component', require('./components/masterData/RoomsComponent.vue').default);
// END OF MASTER DATA


//DOCTOR SPECIALIZATION
Vue.component('doctor-specialization-component', require('./components/DoctorSpecializationComponent.vue').default);



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
