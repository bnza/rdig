/* global require */

import 'babel-polyfill'
import Vue from 'vue'
import Vuetify from 'vuetify'
import store from './store'
import router from './router'
import App from './App.vue'

import 'vuetify/dist/vuetify.min.css'

import '../../assets/fonts/fonts.scss'
require('../../css/app.styl')

// Vue.config.productionTip = false

// sync(store, router)

Vue.use(Vuetify)

window.app = new Vue({
  el: '#app',
  router,
  store,
  template: '<App/>',
  components: { App }
})
