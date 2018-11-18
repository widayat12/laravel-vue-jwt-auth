
require('./bootstrap');
import Vue from 'vue'; // Importing Vue Library
import VueRouter from 'vue-router'; // importing Vue router library
import {routes} from './routes';
import StoreData from './store';
import Vuex from 'vuex';
import MainApp from './components/MainApp.vue';
import {initialize} from './helpers/general';

Vue.use(VueRouter);
Vue.use(Vuex);

const store = new Vuex.Store(StoreData);

const router = new VueRouter({
  routes,
  mode: 'history'
});

initialize(store, router);

const app = new Vue({
    el: '#app',
    router,
    store,
    components:{
      MainApp
    }
});
