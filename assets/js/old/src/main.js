/* global require */

import store from './store'
import router from './router'
import Vue from 'vue'
import App from './App.vue'
import { sync } from 'vuex-router-sync'

import '../../assets/fonts/fonts.scss'
require('../../css/app.scss')

Vue.config.productionTip = false

sync(store, router)

window.app = new Vue({
  el: '#app',
  router,
  store,
  template: '<App/>',
  components: { App }
})
