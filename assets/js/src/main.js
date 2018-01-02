/* global require */

import store from './store'
import router from './router'
import Vue from 'Vue'
import App from './App.vue'

require('../../assets/fonts/vision.scss')
require('../../css/app.scss')

Vue.config.productionTip = false

window.app = new Vue({
  el: '#app',
  router,
  store,
  template: '<App/>',
  components: { App }
})
