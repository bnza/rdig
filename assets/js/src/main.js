/* global require */

import 'babel-polyfill'
import Vue from 'vue'
import Vuetify from 'vuetify'
import store from './store'
import router from './router'
import App from './App.vue'
import { sync } from 'vuex-router-sync'

import 'vuetify/dist/vuetify.min.css'

import '../../assets/fonts/fonts.scss'
require('../../css/app.styl')

// Vue.config.productionTip = false

// sync(store, router)

Vue.use(Vuetify)

sync(store, router)

window.app = new Vue({
  el: '#app',
  router,
  store,
  template: '<App/>',
  components: { App }
})
