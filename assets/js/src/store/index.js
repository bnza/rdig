import Vue from 'vue'
import Vuex from 'vuex'
import account from './account'
import components from './components'
import requests from './requests'

Vue.use(Vuex)

const store = new Vuex.Store({
  modules: {
    account: account,
    components: components,
    requests: requests
  }
})

export default store
