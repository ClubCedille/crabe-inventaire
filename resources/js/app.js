/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import axios from 'axios'
import VueAxios from 'vue-axios'
require('./bootstrap');
import { library } from '@fortawesome/fontawesome-svg-core'
import { faEdit,faPlus,faSave,faTrash } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import Notifications from 'vue-notification'
window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */
Vue.use(Notifications)
library.add(faEdit)
library.add(faPlus)
library.add(faSave)
library.add(faTrash)
Vue.use(VueAxios, axios)
Vue.component('font-awesome-icon', FontAwesomeIcon)
const files = require.context('./', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component(
    'compte-component', 
    require('./components/ActiverCompte.vue').default
);
Vue.component(
    'category-component', 
    require('./components/categoryComponent.vue').default
);
Vue.component(
    'product-component', 
    require('./components/productComponent.vue').default
);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
