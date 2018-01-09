import Vue from 'vue'
import Vuex from 'vuex'
import account from './account'
import requests from './requests'

Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
    panelLeftComponent: 'test-left'
  },
  modules: {
    account: account,
    requests: requests
  },
  mutations: {
    switchLeftComponent (state, component) {
      state.panelLeftComponent = component
    }
  }
})

export default store
