/* eslint-disable no-undef */
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import axios from 'axios';
import VueAxios from 'vue-axios';
import { library } from '@fortawesome/fontawesome-svg-core';
import {
  faEdit,
  faPlus,
  faSave,
  faTrash,
} from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import Notifications from 'vue-notification';
import _ from 'lodash';

import Vuetify from 'vuetify';
import VCalendar from 'v-calendar';
require('./bootstrap');

window.Vue = require('vue');

Vue.prototype.t = (string) => _.get(window.i18n, string);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */
Vue.use(Notifications);
Vue.use(Vuetify);
library.add(faEdit);
library.add(faPlus);
library.add(faSave);
library.add(faTrash);
Vue.use(VueAxios, axios);
Vue.use(VCalendar);
Vue.component('font-awesome-icon', FontAwesomeIcon);
const files = require.context('./', true, /\.vue$/i);
files.keys().map((key) => Vue.component(
  key
    .split('/')
    .pop()
    .split('.')[0],
  files(key).default,
));

Vue.component(
  'compte-component',
  require('./components/ActiverCompte.vue').default,
);
Vue.component(
  'category-component',
  require('./components/categoryComponent.vue').default,
);
Vue.component(
  'product-component',
  require('./components/productComponent.vue').default,
);
Vue.component(
  'category-edit-component',
  require('./components/CategoryEditComponent.vue').default,
);
Vue.component(
  'product-edit-component',
  require('./components/ProductEditComponent.vue').default,
);
Vue.component(
  'product-component',
  require('./components/productComponent.vue').default,
);
/**
 * shop components
 */
Vue.component(
  'item',
  require('./components/shop/item.vue').default,
);
Vue.component(
  'items',
  require('./components/shop/items.vue').default,
);
Vue.component(
  'cart',
  require('./components/shop/cart.vue').default,
);
Vue.component(
  'cart-item',
  require('./components/shop/cartItem.vue').default,
);
Vue.component(
  'report',
  require('./components/report.vue').default,
);

/**
 * receipts components
 */
Vue.component(
  'receipts',
  require('./components/receipts/receipts.vue').default,
);
// Vue.component(
//   "receipt",
//   require("./components/receipts/receipt.vue").default
// );
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// eslint-disable-next-line no-unused-vars
const app = new Vue({
  el: '#app',
  vuetify: new Vuetify(),
});
